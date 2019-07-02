<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Url;
use app\models\GojekOrderView01;

class GoMachineRequestController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');
		$data = [];

		$model = new \yii\base\DynamicModel([
	        'request_date'
	    ]);
	    $model->addRule(['request_date'], 'required');
	    $model->request_date = date('Y-m-d');

	    if (\Yii::$app->request->get('request_date') !== null) {
			$model->request_date = \Yii::$app->request->get('request_date');
		}

		$tmp_order_arr = GojekOrderView01::find()
		->select([
			'request_ymd', 'request_hour',
			'qty_open' => 'SUM(CASE WHEN STAT = \'O\' THEN 1 ELSE 0 END)',
			'qty_close' => 'SUM(CASE WHEN STAT = \'C\' THEN 1 ELSE 0 END)',
		])
		->where([
			'source' => 'MCH',
			'request_ymd' => $model->request_date
		])
		->groupBy('request_ymd, request_hour')
		->orderBy('request_hour')
		->all();
		//echo $model->request_date;
		//echo count($tmp_order_arr);

		$tmp_data = [];
		foreach ($tmp_order_arr as $key => $value) {
			$tmp_request_date = (strtotime($value->request_ymd . ' ' . $value->request_hour . " +7 hours") * 1000);
			if ($value->qty_open > 0) {
				$tmp_data['open'][] = [
					'x' => $tmp_request_date,
					'y' => (int)$value->qty_open,
					'url' => Url::to(['get-remark', 'request_ymd' => $value->request_ymd, 'request_hour' => $value->request_hour, 'STAT' => 'O']),
				];
			}
			
			if ($value->qty_close > 0) {
				$tmp_data['close'][] = [
					'x' => $tmp_request_date,
					'y' => (int)$value->qty_close,
					'url' => Url::to(['get-remark', 'request_ymd' => $value->request_ymd, 'request_hour' => $value->request_hour, 'STAT' => 'C']),
				];
			}
			
		}

		$data[] = [
			'name' => 'ORDER (OPEN)',
			'data' => $tmp_data['open'],
			'color' => 'rgba(255, 0, 0, 0.7)',
		];

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
		]);
	}

	public function actionGetRemark($request_ymd, $request_hour, $STAT)
	{
		date_default_timezone_set('Asia/Jakarta');
		if ($STAT == 'O') {
    		$status = 'OPEN';
    	} else {
    		$status = 'CLOSE';
    	}
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Request ' . $status . ' <small>(' . $request_ymd . ')</small></h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th class="text-center">Req. Time</th>
	    	<th class="text-center">Slip ID</th>
	    	<th>Location</th>
	    	<th>Machine</th>
	    	<th>Model</th>
	    	<th>Requestor</th>
	    	<th>Driver</th>
	    </tr>';

	    $data_arr = GojekOrderView01::find()
	    ->where([
	    	'source' => 'MCH',
	    	'request_ymd' => $request_ymd,
	    	'request_hour' => $request_hour,
	    	'STAT' => $STAT
	    ])
	    ->orderBy('request_date')
	    ->all();

	    $no = 1;
	    foreach ($data_arr as $key => $value) {
	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center" style="font-weight: bold;">' . date('H:i', strtotime($value->request_date)) . '</td>
	    		<td class="text-center">' . $value->slip_id . '</td>
	    		<td>' . $value->to_loc . '</td>
	    		<td>' . $value->item_desc . '</td>
	    		<td>' . $value->model . '</td>
	    		<td>' . $value->NAMA_KARYAWAN . '</td>
	    		<td>' . $value->GOJEK_DESC . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}