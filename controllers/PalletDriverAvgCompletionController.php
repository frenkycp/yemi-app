<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\PalletDriver;
use app\models\SernoSlipLog;
use yii\helpers\Url;

class PalletDriverAvgCompletionController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$data = [];
		$categories = [];
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') != null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') != null) {
            $month = \Yii::$app->request->get('month');
        }

        $period = $year . $month;

        $tmp_driver_arr = PalletDriver::find()
        ->where([
			'driver_type' => 1
		])
        ->orderBy('driver_name')
        ->all();

        $tmp_data = [];
        foreach ($tmp_driver_arr as $tmp_driver) {
        	$nik = $tmp_driver->nik;
        	$driver_name = $tmp_driver->driver_name;
        	$categories[] = $driver_name;

        	$order_data = SernoSlipLog::find()
        	->select([
        		'completion_time' => 'ROUND(AVG(completion_time), 0)'
        	])
        	->where([
        		'nik' => $nik,
        		'EXTRACT(YEAR_MONTH FROM pk)' => $period
        	])
        	->groupBy('EXTRACT(YEAR_MONTH FROM pk)')
        	->one();

        	$avg_completion = 0;
        	if ($order_data->completion_time != null) {
        		$avg_completion = round($order_data->completion_time / 60);
        	}

        	$tmp_data[] = [
        		'y' => $avg_completion,
        		'url' => Url::to(['get-remark', 'nik' => $nik, 'driver_name' => $driver_name, 'period' => $period])
        	];
        }

        $data[] = [
        	'name' => 'One Job Completion Time (AVG)',
			'data' => $tmp_data
        ];

		return $this->render('index', [
			'data' => $data,
			'categories' => $categories,
			'year' => $year,
			'month' => $month,
		]);
	}

	public function actionGetRemark($nik, $driver_name, $period)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Driver : ' . $driver_name . '<small> (' . $nik . ')</small></h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover table-condensed" style="font-size: 12px;">';
	    $remark .= '<tr>
	    	<th class="text-center">No.</th>
	    	<th class="text-center">Post Date</th>
	    	<th class="text-center">Order from Line</th>
	    	<th class="text-center">Departure</th>
	    	<th class="text-center">Arrival</th>
	    	<th class="text-center">LT (min)</th>
	    </tr>';

	    $data_arr = SernoSlipLog::find()
	    ->where([
	    	'nik' => $nik,
	    	'EXTRACT(YEAR_MONTH from pk)' => $period
	    ])
	    ->andWhere('arrival_datetime IS NOT NULL')
	    ->orderBy('completion_time DESC')
	    ->asArray()
	    ->all();

	    $no = 1;
	    foreach ($data_arr as $value) {
	    	$completion_time = round($value['completion_time'] / 60, 1);
    		$remark .= '<tr>
    			<td class="text-center">' . $no . '</td>
	    		<td class="text-center">' . date('Y-m-d', strtotime($value['pk'])) . '</td>
	    		<td class="text-center">' . $value['line'] . '</td>
	    		<td class="text-center">' . $value['departure_datetime'] . '</td>
	    		<td class="text-center">' . $value['arrival_datetime'] . '</td>
	    		<td class="text-center">' . $completion_time . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}