<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\ContainerView;
use app\models\SernoOutput;
use app\models\SernoInput;
use app\models\SernoMaster;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\SernoOutput as SernoOutputSearch;
use app\models\SernoCalendar;
use app\models\WeeklyShippingOutView01;

class WeeklyShippingOutController extends Controller
{
    /*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/
    
    public function actionIndex()
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$min_max_week = SernoOutput::find()
    	->select([
    		'tahun' => 'LEFT(id,4)',
    		'min_week' => 'MIN(WEEK(ship,4))',
    		'max_week' => 'MAX(WEEK(ship,4))'
    	])
    	->where(['<>', 'stc', 'ADVANCE'])
        ->andWhere(['LEFT(id,4)' => date('Y')])
    	//->andWhere(['<>', 'stc', 'NOSO'])
    	//->andWhere(['LEFT(id,4)' => date('Y')])
    	//->andWhere(['<>', 'ship', '9999-12-31'])
    	->groupBy('tahun')
    	->one();

    	$weekToday = SernoCalendar::find()->where(['etd' => date('Y-m-d')])->one()->week_ship;

        $start_week = 1;
        $end_week = 52;

        if(count($min_max_week) > 0)
        {
            $start_week = $min_max_week->max_week - 10;
            if ($start_week < 1) {
                $start_week = 1;
            }
            $end_week = $min_max_week->max_week;
        }

        /*$sql = 'select week(`so`.`ship`,4) AS `week_no`,`so`.`etd` AS `etd`,`so`.`ship` AS `ship`,`so`.`qty` AS `total_qty`,(select count(`tb_serno_input`.`pk`) from `tb_serno_input` where ((`tb_serno_input`.`plan` = `so`.`pk`) and (`tb_serno_input`.`loct` = 3))) AS `total_output` from `tb_serno_output` `so`';
        $data_arr = SernoOutput::findBySql($sql)->all();*/

        /*$tmp_so_data = SernoOutput::find()
        ->select([
            'week_no' => 'WEEK(ship, 4)',
            'etd',
            'ship',
            'uniq',
            'so',
            'total_qty' => 'qty',
            'total_output' => 'output',
        ])
        ->all();

        $shipping_data_arr = WeeklyShippingOutView02::find()
        ->where(['>=', 'week_no', $start_week])
        ->asArray()
        ->all();*/

        $shipping_data_arr = WeeklyShippingOutView01::find()
        ->select([
            'week_no',
            'etd',
            'plan_qty' => 'SUM(plan_qty)',
            'actual_qty' => 'SUM(actual_qty)'
        ])
        ->where(['>=', 'week_no', $start_week])
        ->andWhere(['year' => date('Y')])
        ->groupBy('week_no, etd')
        ->orderBy('week_no, etd')
        ->all();

        foreach ($shipping_data_arr as $key => $shipping_data) {
            $etd = $shipping_data['etd'];
            $plan_qty = $shipping_data['plan_qty'];
            $actual_qty = $shipping_data['actual_qty'];
            if ($etd < date('Y-m-d')) {
                $actual_qty = $plan_qty;
            }
            $week_no = $shipping_data['week_no'];
            $open_percentage = round((($plan_qty - $actual_qty) / $plan_qty) * 100);
            $close_percentage = 100 - $open_percentage;
            if ($close_percentage == 0 && $actual_qty > 0) {
                $close_percentage = ceil(($actual_qty / $plan_qty) * 100);
                $open_percentage = 100 - $close_percentage;
            }

            $tmp_data[$week_no]['open'][] = [
                'y' => $open_percentage == 0 ? null : $open_percentage,
                'qty' => (int)$plan_qty - $actual_qty,
                'url' => Url::to(['get-remark', 'etd' => $etd, 'status' => 'OPEN']),
                //'url' => Url::to(['serno-output/index', 'index_type' => 1, 'etd' => $etd, 'out' => 1]),
            ];
            $tmp_data[$week_no]['close'][] = [
                'y' => $close_percentage,
                'qty' => (int)$actual_qty,
                'url' => Url::to(['get-remark', 'etd' => $etd, 'status' => 'CLOSE']),
                //'url' => Url::to(['serno-output/index', 'index_type' => 2, 'etd' => $etd, 'out' => 1]),
            ];
            $tmp_data[$week_no]['categories'][] = $etd;
        }

        foreach ($tmp_data as $key => $value) {
            $data[$key]['series'] = [
                [
                    'name' => 'OPEN',
                    'data' => $value['open'],
                    'color' => 'FloralWhite',
                    'dataLabels' => [
                        'enabled' => true,
                        'color' => 'black',
                        'format' => '{point.percentage:.0f}% ({point.qty})',
                        'style' => [
                            'textOutline' => '0px'
                        ],
                        'allowOverlap' => true,
                    ],
                ],
                [
                    'name' => 'CLOSE',
                    'data' => $value['close'],
                    'color' => 'rgba(0, 150, 255, 0.5)',
                    'dataLabels' => [
                        'enabled' => true,
                        'color' => 'black',
                        'format' => '{point.percentage:.0f}%',
                        'style' => [
                            'textOutline' => '0px'
                        ],
                    ],
                ],
            ];
            $data[$key]['categories'] = $value['categories'];
        }

        return $this->render('index',[
        	'weekToday' => $weekToday,
        	'startWeek' => $start_week,
        	'endWeek' => $end_week,
            'data' => $data,
        ]);
    }

    public function actionGetRemark($etd, $status)
    {

        $serno_output_arr = WeeklyShippingOutView01::find()
        ->select([
            'uniq',
            'so',
            'dst',
            'gmc',
            'plan_qty' => 'SUM(plan_qty)',
            'actual_qty' => 'SUM(actual_qty)',
            'stc',
            'etd',
            'etd_old',
            'ship',
            'cntr',
            'remark' => 'MAX(remark)',
            'week_no'
        ])
        ->where(['<>', 'stc', 'ADVANCE'])
        ->andWhere([
            'etd' => $etd
        ])
        ->groupBy('uniq, so')
        ->orderBy('dst, gmc')
        ->all();

        $data = '<h4>' . $status . ' <small>on ' . date('Y-m-d', strtotime($etd)) . '</small></h4>';
        $data .= '<table class="table table-bordered table-hover">';
        $data .= 
        '<thead style="font-size: 12px;"><tr class="info">
            <th class="text-center">SO</th>
            <th class="text-center">STC</th>
            <th class="text-center">Destination</th>
            <th class="text-center">GMC</th>
            <th>Description</th>
            <th class="text-center" style="min-width: 60px;">Qty</th>
            <th class="text-center" style="min-width: 60px;">Container</th>
            <th class="text-center" style="min-width: 60px;">Remark</th>
            <th class="text-center" style="min-width: 60px;">Etd Before</th>
        </tr></thead>';
        $data .= '<tbody style="font-size: 12px;">';

        foreach ($serno_output_arr as $value) {
            $diff_qty = $value->actual_qty - $value->plan_qty;
            $tmp_so = SernoMaster::find()
            ->where([
                'gmc' =>$value->gmc
            ])
            ->one();

            $desc = '-';
            if ($tmp_so->gmc != null) {
                $desc = $tmp_so->model . ' // ' . $tmp_so->color . ' // ' . $tmp_so->dest;
            }
            if ($status == 'OPEN') {
                if ($diff_qty < 0) {
                    $data .= '
                        <tr>
                            <td class="text-center">' . $value->so . '</td>
                            <td class="text-center">' . $value->stc . '</td>
                            <td class="text-center">' . $value->dst . '</td>
                            <td class="text-center">' . $value->gmc . '</td>
                            <td>' . $desc . '</td>
                            <td class="text-center">' . $diff_qty . '</td>
                            <td class="text-center">' . $value->cntr . '</td>
                            <td class="text-center text-red">' . $value->remark . '</td>
                            <td class="text-center">' . $value->etd_old . '</td>
                        </tr>
                    ';
                }
            } else {
                if ($value->actual_qty > 0) {
                    $data .= '
                        <tr>
                            <td class="text-center">' . $value->so . '</td>
                            <td class="text-center">' . $value->stc . '</td>
                            <td class="text-center">' . $value->dst . '</td>
                            <td class="text-center">' . $value->gmc . '</td>
                            <td>' . $desc . '</td>
                            <td class="text-center">' . $value->actual_qty . '</td>
                            <td class="text-center">' . $value->cntr . '</td>
                            <td class="text-center text-red">' . $value->remark . '</td>
                            <td class="text-center">' . $value->etd_old . '</td>
                        </tr>
                    ';
                }
                
            }

        }
        $data .= '</tbody>';

        $data .= '</table>';
        return $data;
    }
}