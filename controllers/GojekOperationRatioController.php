<?php

namespace app\controllers;

use yii\web\Controller;

use app\models\GojekTbl;
use app\models\GojekOrderReport;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class GojekOperationRatioController extends Controller
{
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sql = "{CALL CREATE_GOJEK_ORDER}";
		$result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryAll();
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') != null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') != null) {
            $month = \Yii::$app->request->get('month');
        }

        $period = $year . $month;

		$tmp_driver_arr = GojekTbl::find()
		->where(['<>', 'TERMINAL', 'Z'])
		->orderBy('GOJEK_DESC')
		->all();

		$tmp_data1 = [];
		foreach ($tmp_driver_arr as $tmp_driver) {
			$nik = $tmp_driver->GOJEK_ID;
			$name = $tmp_driver->GOJEK_DESC;
			$order_report_arr = GojekOrderReport::find()
			->where([
				'NIK' => $nik,
				'period' => $period,
				'source' => 'WIP'
			])
			->orderBy('post_date')
			->all();
			foreach ($order_report_arr as $value) {
				//$post_date = date('Y-m-d', strtotime($value->post_date));
				$post_date = (strtotime($value->post_date . " +7 hours") * 1000);
				$tmp_data1[$nik]['workhour'][] = [
					'x' => $post_date,
					'y' => round($value->Duration / 3600, 1)
				];
				$tmp_data1[$nik]['idle'][] = [
					'x' => $post_date,
					'y' => round($value->iddle / 3600, 1)
				];
				$tmp_data1[$nik]['break'][] = [
					'x' => $post_date,
					'y' => round($value->waktu_istirahat / 3600, 1)
				];
			}
			$tmp_data1[$nik]['nama'] = $name;
		}

		$data = [];
		foreach ($tmp_data1 as $key => $value) {
			$data[$key]['nama'] = $value['nama'];
			$data[$key]['data'] = [
				[
					'name' => 'Idle Time',
					'data' => $value['idle'],
					'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
				],
				[
					'name' => 'Delivery',
					'data' => $value['workhour'],
					'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
				],
				/*[
					'name' => 'Break Time',
					'data' => $value['break'],
					'color' => new JsExpression('Highcharts.getOptions().colors[4]'),
				],*/
			];
		}

		return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}
}