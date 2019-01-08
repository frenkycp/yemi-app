<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\WipEffViewRunPerDay2;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;

class SmtPerformanceRatioController extends Controller
{
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

		$eff_data_arr = WipEffViewRunPerDay2::find()
		->where([
			'period' => $period
		])
		->orderBy('LINE, post_date')
		->all();

		$tmp_data = [];
		foreach ($eff_data_arr as $eff_data) {
			$post_date = (strtotime($eff_data->post_date . " +7 hours") * 1000);
			$line = $eff_data->LINE;

			$working_hour = round($eff_data->machine_run_second_2 / 60);
			$idle_hour = round($eff_data->total_iddle_second / 60);
			$off_hour = round($eff_data->machine_off / 60);

			$tmp_data[$line]['working_time'][] = [
				'x' => $post_date,
				'y' => $working_hour
			];
			$tmp_data[$line]['idle_time'][] = [
				'x' => $post_date,
				'y' => $idle_hour,
				'url' => Url::to(['smt-daily-utility-report/get-loss-time-line', 'proddate' => date('Y-m-d', strtotime($eff_data->post_date)), 'line' => $line]),
				'events' => [
                    'click' => new JsExpression("
                        function(e){
                            e.preventDefault();
                            $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                        }
                    "),
                ]
			];
			$tmp_data[$line]['off_time'][] = [
				'x' => $post_date,
				'y' => $off_hour
			];
		}

		foreach ($tmp_data as $key => $value) {
			$data[$key]['data'] = [
				[
					'name' => 'Idle',
					'data' => $value['idle_time'],
					'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
					'cursor' => 'pointer',
				],
				[
					'name' => 'Running',
					'data' => $value['working_time'],
					'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
				],
				[
					'name' => 'Off',
					'data' => $value['off_time'],
					'color' => new JsExpression('Highcharts.getOptions().colors[4]'),
				],
			];
		}

		$monthly_data_arr = WipEffViewRunPerDay2::find()
		->select([
			'period',
			'machine_run_second_2' => 'SUM(machine_run_second_2)',
			'total_iddle_second' => 'SUM(total_iddle_second)',
			'machine_off' => 'SUM(machine_off)',
		])
		->where([
			'LEFT(period, 4)' => $year
		])
		->groupBy('period')
		->orderBy('period')
		->all();

		$tmp_data2 = [];
		$categories2 = [];
		$tmp_running = $tmp_idling = $tmp_off = [];
		foreach ($monthly_data_arr as $key => $value) {
			$categories2[] = $value->period;
			$tmp_running[]= round($value->machine_run_second_2 / 3600, 1);
			$tmp_idling[] = round($value->total_iddle_second / 3600, 1);
			$tmp_off[] = round($value->machine_off / 3600, 1);
		}

		$data2 = [
			[
				'name' => 'Idle',
				'data' => $tmp_idling,
				'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
				//'cursor' => 'pointer',
			],
			[
				'name' => 'Running',
				'data' => $tmp_running,
				'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
			],
			[
				'name' => 'Off',
				'data' => $tmp_off,
				'color' => new JsExpression('Highcharts.getOptions().colors[4]'),
			],
		];

		return $this->render('index', [
			'data' => $data,
			'data2' => $data2,
			'categories2' => $categories2,
			'year' => $year,
			'month' => $month,
		]);
	}

	public function getMonthlyPerformanceData($year)
	{
		$data = [];

		$data_arr = WipEffViewRunPerDay2::find()
		->all();
	}

}