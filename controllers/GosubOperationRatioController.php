<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\GojekTbl;
use app\models\GeneralFunction;
use app\models\GojekOrderTbl;
use app\models\GojekOrderReport;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

class GosubOperationRatioController extends Controller
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
		->where([
			'SOURCE' => 'SUB'
		])
		->orderBy('GOJEK_DESC')
		->all();

		$order_report_arr = GojekOrderTbl::find()
		->select([
			'post_date', 'GOJEK_ID', 'GOJEK_DESC',
			'LT' => 'SUM(LT)'
		])
		->where([
			'FORMAT(post_date, \'yyyyMM\')' => $period,
			'source' => 'SUB'
		])
		->groupBy('post_date, GOJEK_ID, GOJEK_DESC')
		->orderBy('post_date')
		->all();

		$started_job = GojekOrderTbl::find()
		->select([
			'GOJEK_ID', 'STAT', 'source', 'post_date', 'daparture_date'
		])
		->where([
			'STAT' => 'O',
			'source' => 'SUB',
			'post_date' => date('Y-m-d')
		])
		->andWhere('daparture_date IS NOT NULL')
		->all();

		$tmp_data1 = [];
		$tmp_data2 = [];
		foreach ($tmp_driver_arr as $tmp_driver) {
			$nik = $tmp_driver->GOJEK_ID;
			$name = $tmp_driver->GOJEK_DESC;
			/*$order_report_arr = GojekOrderReport::find()
			->where([
				'NIK' => $nik,
				'period' => $period,
				'source' => 'SUB'
			])
			->orderBy('post_date')
			->all();*/
			foreach ($order_report_arr as $value) {
				//$post_date = date('Y-m-d', strtotime($value->post_date));
				if ($value->GOJEK_ID == $nik) {
					$post_date = (strtotime($value->post_date . " +7 hours") * 1000);
					$post_date_ymd = date('Y-m-d', strtotime($value->post_date));
					if (!isset($tmp_data2[$post_date_ymd]['workhour'])) {
						$tmp_data2[$post_date_ymd]['workhour'] = 0;
					}
					if (!isset($tmp_data2[$post_date_ymd]['idle'])) {
						$tmp_data2[$post_date_ymd]['idle'] = 0;
					}

					$lt = 0;
					if ($value->LT != null) {
						$lt = $value->LT;
					}
					
					if ($post_date_ymd == date('Y-m-d')) {
						foreach ($started_job as $key => $started_data) {
							if ($started_data->GOJEK_ID == $nik) {
								$lt += GeneralFunction::instance()->getWorkingTime($started_data->daparture_date, date('Y-m-d H:i:s'));
							}
						}
					}

					$tmp_data2[$post_date_ymd]['workhour'] += $lt;
					$idle_minutes = 480 - $lt;
					if ($idle_minutes < 0) {
						$idle_minutes = 0;
					}
					$tmp_data2[$post_date_ymd]['idle'] += $idle_minutes;

					$tmp_data1[$nik]['workhour'][] = [
						'x' => $post_date,
						'y' => round($lt/60, 1)
					];
					$tmp_data1[$nik]['idle'][] = [
						'x' => $post_date,
						'y' => $idle_minutes == null ? 0 : round($idle_minutes/60, 1)
					];
				}
				
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
					'name' => 'Working Time',
					'data' => $value['workhour'],
					'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
				],
			];
		}

		$tmp_data3 = [];
		foreach ($tmp_data2 as $key => $value) {
			$post_date = (strtotime($key . " +7 hours") * 1000);
			$tmp_data3['workhour'][] = [
				'x' => $post_date,
				'y' => round(($value['workhour'] / 60), 1)
			];
			$tmp_data3['idle'][] = [
				'x' => $post_date,
				'y' => round(($value['idle'] / 60), 1)
			];
		}
		$data2 = [
			[
				'name' => 'Iddle Time (Total)',
				'data' => $tmp_data3['idle'],
				'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
			],
			[
				'name' => 'Working Time (Total)',
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