<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\PcPiVariance;
use app\models\StoreOnhandWsus;
use app\models\FiscalTbl;
use app\models\WipOutputMonthlyView;
use app\models\WipHdrDtr;
use app\models\ProdNgData;
use app\models\DbSmtMaterialInOut;

class DisplayPrdController extends Controller
{
    public function actionDailySmtReel($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        $tmp_in_out = DbSmtMaterialInOut::find()
        ->select([
            'post_date' => 'DATE(tgl)',
            'total_count' => 'COUNT(id_part)'
        ])
        ->where([
            'AND',
            ['>=', 'tgl', $model->from_date . ' 00:00:00'],
            ['<=', 'tgl', $model->to_date . ' 23:59:59']
        ])
        ->andWhere(['RIGHT(pk,2)' => '_0'])
        ->andWhere(['!=', 'id_part', ''])
        ->groupBy(['DATE(tgl)'])
        ->orderBy('post_date')
        ->all();

        foreach ($tmp_in_out as $key => $value) {
            $post_date = (strtotime($value->post_date . " +7 hours") * 1000);
            $tmp_data[] = [
                'x' => $post_date,
                'y' => (int)$value->total_count,
            ];
        }

        $data = [
            [
                'name' => 'Total Count',
                'data' => $tmp_data
            ],
        ];

        return $this->render('daily-smt-reel', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionDailyMountCountingMaterial($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        $tmp_in_out = DbSmtMaterialInOut::find()
        ->select([
            'post_date' => 'DATE(tgl)',
            'total_count' => 'COUNT(tgl)'
        ])
        ->where([
            'AND',
            ['>=', 'tgl', $model->from_date . ' 00:00:00'],
            ['<=', 'tgl', $model->to_date . ' 23:59:59']
        ])
        ->groupBy(['DATE(tgl)'])
        ->orderBy('post_date')
        ->all();

        foreach ($tmp_in_out as $key => $value) {
            $post_date = (strtotime($value->post_date . " +7 hours") * 1000);
            $tmp_data[] = [
                'x' => $post_date,
                'y' => (int)$value->total_count,
            ];
        }

        $data = [
            [
                'name' => 'Total Count',
                'data' => $tmp_data
            ],
        ];

        return $this->render('daily-mount-counting-material', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionWipNgRateGetRemark($child_analyst, $period, $total_output)
    {
        $location = \Yii::$app->params['ng_rate_location_arr'][$child_analyst];
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><u>' . $location . ' <small>(' . $period . ')</small></u><br/>Total Output : ' . number_format($total_output) . '</h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 12px;">
            <th class="text-center" style="min-width: 90px;">Date</th>
            <th class="">Model</th>
            <th class="text-center">NG Qty</th>
            <th class="text-center">Root Cause</th>
            <th class="text-center">NG Category</th>
            <th class="text-center">NG Category Detail</th>
            <th class="">Remark</th>
        </tr>';

        if ($child_analyst == 'INJ') {
            $child_analyst = ['WI01', 'WI02', 'WI03'];
        }

        $tmp_ng_arr = ProdNgData::find()
        ->where([
            'loc_id' => $child_analyst,
            'period' => $period,
            'flag' => 1
        ])
        ->andWhere(['>', 'ng_qty', 0])
        ->orderBy('post_date')
        ->all();

        $no = 1;
        foreach ($tmp_ng_arr as $key => $value) {
            if ($value->part_no == null) {
                $part_no = $value->part_no;
                $part_desc = $value->part_desc;
            } else {
                $part_no = $value->pcb_id;
                $part_desc = $value->pcb_name;
            }
            $remark .= '<tr style="font-size: 12px;">
                <td class="text-center">' .$value->post_date . '</td>
                <td class="">' .$value->gmc_desc . '</td>
                <td class="text-center">' .$value->ng_qty . '</td>
                <td class="text-center">' .$value->ng_cause_category . '</td>
                <td class="text-center">' .$value->ng_category_desc . '</td>
                <td class="text-center">' .$value->ng_category_detail . '</td>
                <td class="">' .$value->ng_detail . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

	public function actionWipNgRate()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $tmp_data = $data = [];

        $model = new \yii\base\DynamicModel([
            'fiscal', 'location'
        ]);
        $model->addRule(['fiscal', 'location'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal = $current_fiscal->FISCAL;
        $model->location = ['INJ', 'WP01'];

        if ($model->load($_GET)) {
            
        };

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $model->fiscal
        ])
        ->orderBy('PERIOD')
        ->all();
        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        $tmp_output_monthly = WipOutputMonthlyView::find()
        ->select([
            'child_analyst_group', 'period', 'total_qty' => 'SUM(total_qty)'
        ])
        ->where([
            'child_analyst_group' => $model->location,
            //'period' => $period_arr
        ])
        ->groupBy('child_analyst_group, period')
        ->all();

        foreach ($model->location as $location_val) {
            if ($location_val == 'INJ') {
                $tmp_location = ['WI01', 'WI02', 'WI03'];
            } else {
                $tmp_location = $location_val;
            }

            /*$tmp_output_monthly = WipOutputMonthlyView::find()
            ->select([
                'period', 'total_qty' => 'SUM(total_qty)'
            ])
            ->where([
                'child_analyst' => $tmp_location,
                'period' => $period_arr
            ])
            ->groupBY('period')
            ->orderBy('period')
            ->all();*/

            

            $tmp_total_ng = ProdNgData::find()
            ->select([
                'period',
                'ng_qty' => 'SUM(ng_qty)'
            ])
            ->where([
                'loc_id' => $tmp_location,
                'period' => $period_arr,
                'flag' => 1
            ])
            ->groupBy('period')
            ->orderBy('period')
            ->all();

            foreach ($period_arr as $period_val) {
                $tmp_output = $tmp_ng = 0;
                
                foreach ($tmp_total_ng as $ng_row) {
                    if ($ng_row->period == $period_val) {
                        $tmp_ng = $ng_row->ng_qty;
                    }
                }

                foreach ($tmp_output_monthly as $output_row) {
                    if ($output_row->period == $period_val && $output_row->child_analyst_group == $location_val) {
                        $tmp_output = $output_row->total_qty;
                    }
                }

                $tmp_pct = 0;
                if ($tmp_output > 0) {
                    $tmp_pct = round(($tmp_ng / $tmp_output) * 100, 3);
                }

                $tmp_data[$location_val][] = [
                    'y' => $tmp_pct,
                    'url' => Url::to(['wip-ng-rate-get-remark', 'child_analyst' => $location_val, 'period' => $period_val, 'total_output' => $tmp_output])
                ];
                /*$data[$location_val][$period_val] = [
                    'output' => $tmp_output,
                    'ng' => $tmp_ng
                ];*/
            }
        }

        foreach ($tmp_data as $key => $value) {
            $data[] = [
                'name' => \Yii::$app->params['ng_rate_location_arr'][$key],
                'data' => $value
            ];
        }

        return $this->render('wip-ng-rate', [
            'data' => $data,
            'model' => $model,
            'period_arr' => $period_arr,
        ]);
    }
}