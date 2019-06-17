<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;

use app\models\MachineIotCurrentEffLog;

class MntIotUtilityController extends Controller
{
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');

		$data = [];
		//$year = date('Y');
		//$month = date('m');
		$categories = [];

		$model = new \yii\base\DynamicModel([
	        'year', 'month', 'machine_id'
	    ]);
	    $model->addRule(['year', 'month', 'machine_id'], 'required');
	    $model->year = date('Y');
	    $model->month = date('m');

		if (\Yii::$app->request->get('year') !== null) {
			$model->year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$model->month = \Yii::$app->request->get('month');
		}

		if (\Yii::$app->request->get('machine_id') !== null) {
			$model->machine_id = \Yii::$app->request->get('machine_id');
		}



		if ($model->load($_GET)) {
			$period = $model->year . $model->month;

			$iot_monthly_data = MachineIotCurrentEffLog::find()
			->select([
				'posting_shift',
				'hijau' => 'SUM(hijau)',
				'hijau_biru' => 'SUM(hijau_biru)'
			])
			->where([
				'period_shift' => $period,
				'mesin_id' => $model->machine_id,
			])
			->groupBy('posting_shift')
			->all();

			$iot_hour_data2 = MachineIotCurrentEffLog::find()
			->where([
				'period_shift' => $period,
				'mesin_id' => $model->machine_id,
			])
			->asArray()
			->all();

			$tmp_data = [];
			foreach ($iot_monthly_data as $key => $value) {
				$proddate = (strtotime($value['posting_shift'] . " +7 hours") * 1000);
				$util = 0;
				if ($value['hijau_biru'] > 0) {
					$util = round(($value['hijau'] / $value['hijau_biru']) * 100, 1);
				}

				$tmp_data[] = [
					'name' => date('Y-m-d', strtotime($value['posting_shift'])) . '',
					'y' => $util,
					'drilldown' => $util == 0 ? null : date('Y-m-d', strtotime($value['posting_shift'])) . ''
				];

				$start_hour = 7;
				$tmp_data_by_hours2 = [];
				for ($i=1; $i <= 24; $i++) {
					$seq = str_pad($i, 2, '0', STR_PAD_LEFT);
					$pct = null;
					if ($start_hour == 24) {
						$start_hour = 0;
					}
					foreach ($iot_hour_data2 as $key => $value2) {
						if ($seq == $value2['seq'] && $value['posting_shift'] == $value2['posting_shift']) {
							$pct = (int)$value2['pct'];
						}
					}
					$tmp_data_by_hours2[] = [
						$start_hour . '',
						$pct == 0 ? null : $pct
					];

					$start_hour++;
				}
				$drilldown_series[] = [
					'name' => date('Y-m-d', strtotime($value['posting_shift'])) . '',
					'id' => date('Y-m-d', strtotime($value['posting_shift'])) . '',
					'data' => $tmp_data_by_hours2
				];
			}
		}

		$data['day'] = [
			'series' => [
				[
					'name' => 'Daily Utility',
					'data' => $tmp_data,
					'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
				]
			],
			'drilldown_series' => $drilldown_series
		];

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
			'machine_id' => $machine_id,
		]);
	}
}