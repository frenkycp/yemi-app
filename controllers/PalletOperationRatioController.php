<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\PalletDriver;
use app\models\SernoSlipLog;
use yii\web\JsExpression;

class PalletOperationRatioController extends Controller
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
		->orderBy('driver_name')
		->all();

		$tmp_data = [];
		foreach ($tmp_driver_arr as $key => $tmp_driver) {
			$nik = $tmp_driver->nik;

			$tmp_log_arr = SernoSlipLog::find()
			->select([
				'order_date' => 'DATE(pk)',
				'start_time' => 'MIN(departure_datetime)',
				'end_time' => 'MAX(arrival_datetime)',
				'total_working' => 'SUM(completion_time)'
			])
			->where([
				//'DATE(departure_datetime)' => 'DATE(arrival_datetime)',
				'nik' => $nik,
				'extract(year_month from pk)' => $period
			])
			->groupBy('DATE(pk)')
			->all();

			foreach ($tmp_log_arr as $key => $tmp_log) {
				$start_time = $tmp_log->start_time;
				$post_date = (strtotime($tmp_log->order_date . " +7 hours") * 1000);
				
				if ($start_time > date('Y-m-d H:i:s', strtotime($tmp_log->order_date . ' 07:00:00'))) {
					$start_time = date('Y-m-d H:i:s', strtotime($tmp_log->order_date . ' 07:00:00'));
				}

				$end_time = $tmp_log->end_time;
				if ($end_time < date('Y-m-d H:i:s', strtotime($tmp_log->order_date . ' 16:00:00'))) {
					$end_time = date('Y-m-d H:i:s', strtotime($tmp_log->order_date . ' 16:00:00'));
				}

				$target_duration = (strtotime($end_time) - strtotime($start_time)) - 3600;
				$working_time = $tmp_log->total_working;
				$break_time = 3600;
				$idle_time = $target_duration - ($working_time + $break_time);

				$working_hour = round($working_time / 3600, 1);
				$break_hour = round($break_time / 3600, 1);
				$idle_hour = round($idle_time / 3600, 1);

				//hacking tool for make 8 hour
				/*if ($working_hour + $idle_hour > 20) {
					if ($working_hour > $idle_hour) {
						$working_hour = 8 - $idle_hour;
					} else {
						$idle_hour = 8 - $working_hour;
					}
				}*/

				$tmp_data[$nik]['working_time'][] = [
					'x' => $post_date,
					'y' => $working_hour
				];
				$tmp_data[$nik]['break_time'][] = [
					'x' => $post_date,
					'y' => $break_hour
				];
				$tmp_data[$nik]['idle_time'][] = [
					'x' => $post_date,
					'y' => $idle_hour
				];
			}
			$tmp_data[$nik]['name'] = $tmp_driver->driver_name;
		}

		foreach ($tmp_data as $key => $value) {
			$data[$key]['nama'] = $value['name'];
			$data[$key]['data'] = [
				[
					'name' => 'Idle Time',
					'data' => $value['idle_time'],
					'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
				],
				[
					'name' => 'Delivery',
					'data' => $value['working_time'],
					'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
				],
				/*[
					'name' => 'Break Time',
					'data' => $value['break_time'],
					'color' => new JsExpression('Highcharts.getOptions().colors[4]'),
				],*/
			];
		}

		return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'month' => $month
		]);
	}
}