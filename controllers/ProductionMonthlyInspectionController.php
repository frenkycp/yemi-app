<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\InspectionReportView;
use app\models\SernoInput;
use app\models\PlanReceivingPeriod;
use yii\helpers\Url;

/**
 * summary
 */
class ProductionMonthlyInspectionController extends Controller
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	
    	$categories = [];

    	$year_arr = [];
        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $year_now = date('Y');
        $start_year = 2018;
        for ($year = $start_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        $model = new PlanReceivingPeriod();
        $model->month = date('m');
        $model->year = date('Y');
        if ($model->load($_GET))
        {

        }

        $periode = $model->year . $model->month;

    	/*$inspection_data_arr = InspectionReportView::find()
    	->where([
    		'periode' => $periode
    	])
    	->andWhere('total_lot_out > 0 OR total_repair > 0')
    	->orderBy('proddate')
    	->all();*/

        $inspection_data_arr = SernoInput::find()
        ->select([
            'period' => 'extract(year_month from proddate)',
            //'week_no' => 'week(proddate, 4)',
            'proddate',
            'total_data' => 'COUNT(proddate)',
            'total_no_check' => 'SUM((CASE WHEN ((qa_ng = \'\') and (qa_ok = \'\')) then 1 ELSE 0 END))',
            'total_ok' => 'SUM((CASE WHEN ((qa_ng = \'\') and (qa_ok = \'OK\')) then 1 ELSE 0 END))',
            'total_lot_out' => 'SUM((CASE WHEN ((qa_ng <> \'\') and (qa_result <> 2)) then 1 ELSE 0 END))',
            'total_repair' => 'SUM((CASE WHEN ((qa_ng <> \'\') and (qa_result = 2)) then 1 ELSE 0 END))',
        ])
        ->where([
            'extract(year_month from proddate)' => $periode,
            'qa_report' => 0
        ])
        ->groupBy('proddate')
        ->all();

    	$tmp_data = [];
        $tmp_data2 = [];
    	foreach ($inspection_data_arr as $inspection_data) {
    		$categories[] = $inspection_data->proddate;
    		
    		$tmp_data[] = [
    			'y' => $inspection_data->total_lot_out == 0 ? null : (int)$inspection_data->total_lot_out,
    			'url' => Url::to(['production-inspection/index', 'proddate' => $inspection_data->proddate, 'status' => 'LOT OUT'])
    		];
            $tmp_data2[] = [
                'y' => $inspection_data->total_repair == 0 ? null : (int)$inspection_data->total_repair,
                'url' => Url::to(['production-inspection/index', 'proddate' => $inspection_data->proddate, 'status' => 'REPAIR'])
            ];
    	}

    	$data = [
            [
                'name' => 'Repair 個別不良',
                'data' => $tmp_data2,
                'color' => 'rgba(0, 0, 255, 0.5)'
            ],
    		[
    			'name' => 'Lot Out ロットアウト',
    			'data' => $tmp_data,
    			'color' => 'rgba(255, 0, 0, 0.5)'
    		],
            
    	];

    	return $this->render('index', [
    		'data' => $data,
    		'categories' => $categories,
    		'model' => $model,
    		'year_arr' => $year_arr,
    		'month_arr' => $month_arr,
    		''
    	]);
    }

    public function getNgDataRemark($proddate)
    {
    	$detail_data_arr = SernoInput::find()
    	->where([
    		'proddate' => $proddate
    	])
    	->andWhere(['<>', 'qa_ng', ''])
    	->all();

    	$data = '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<tr class="info">
            <th class="text-center">Prod. Date</th>
            <th class="text-center">Line</th>
            <th class="text-center">GMC</th>
            <th class="text-center">Serial No.</th>
            <th class="text-center">NG Remark</th>
            <th class="text-center">NG Date</th>
        </tr>';

        foreach ($detail_data_arr as $detail_data) {
    	$data .= '
            <tr>
                <td class="text-center">' . $detail_data->proddate .'</td>
                <td class="text-center">' . $detail_data->line .'</td>
                <td class="text-center">' . $detail_data->gmc .'</td>
                <td class="text-center">' . $detail_data->sernum .'</td>
                <td class="text-center">' . $detail_data->qa_ng .'</td>
                <td class="text-center">' . $detail_data->qa_ng_date .'</td>
            </tr>
        ';
        }

        $data .= '</table>';

        return $data;
    }
}