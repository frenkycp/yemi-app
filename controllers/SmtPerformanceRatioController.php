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

		return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}
	
}