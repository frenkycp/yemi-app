<?php

namespace app\controllers;

use yii\web\Controller;

use app\models\GojekTbl;
use app\models\GojekOrderReport;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class GojekOperationRatioController extends Controller
{
	
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

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
		->andWhere(['<>', 'TERMINAL', 'K'])
		->orderBy('GOJEK_DESC')
		->all();

		$tmp_data1 = [];
		$tmp_data2 = [];
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
				if (!isset($tmp_data2[$post_date]['workhour'])) {
					$tmp_data2[$post_date]['workhour'] = 0;
				}
				if (!isset($tmp_data2[$post_date]['idle'])) {
					$tmp_data2[$post_date]['idle'] = 0;
				}

				$tmp_data2[$post_date]['workhour'] += $value->Duration;
				$tmp_data2[$post_date]['idle'] += $value->iddle;

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
					'name' => 'Iddle Time',
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

		$data2 = [];
		$tmp_data3 = [];
		foreach ($tmp_data2 as $key => $value) {
			$tmp_data3['workhour'][] = [
				'x' => $key,
				'y' => round(($value['workhour'] / 3600), 1)
			];
			$tmp_data3['idle'][] = [
				'x' => $key,
				'y' => round(($value['idle'] / 3600), 1)
			];
		}
		$data2 = [
			[
				'name' => 'Iddle Time (Total)',
				'data' => $tmp_data3['idle'],
				'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
			],
			[
				'name' => 'Delivery (Total)',
				'data' => $tmp_data3['workhour'],
				'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
			],
		];

		return $this->render('index', [
			'data' => $data,
			'data2' => $data2,
			'year' => $year,
			'month' => $month,
		]);
	}
}