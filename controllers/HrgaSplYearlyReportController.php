<?php

namespace app\controllers;

use yii\web\Controller;
use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\SplViewActVsBgt03;
use yii\web\JsExpression;

class HrgaSplYearlyReportController extends Controller
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
		$data_final = [];
		$budget_sum_arr = [];
		$actual_sum_arr = [];

		$spl_data_arr = SplViewActVsBgt03::find()->all();

		foreach ($spl_data_arr as $key => $value) {
			if (!in_array($value->PERIOD, $categories)) {
				$categories[] = $value->PERIOD;
			}

			if (!isset($budget_sum_arr[$value->PERIOD])) {
				$budget_sum_arr[$value->PERIOD] = $value->BUDGET;
			} else {
				$budget_sum_arr[$value->PERIOD] += $value->BUDGET;
			}

			if (!isset($actual_sum_arr[$value->PERIOD])) {
				$actual_sum_arr[$value->PERIOD] = $value->ACTUAL;
			} else {
				$actual_sum_arr[$value->PERIOD] += $value->ACTUAL;
			}

			$data[$value->DIVISION]['BUDGET'][] = $value->BUDGET;
			$data[$value->DIVISION]['ACTUAL'][] = $value->ACTUAL == 0 ? $value->BUDGET : $value->ACTUAL;
		}

		$tmp_budget_data = [];
		$tmp_actual_data = [];
		$total_budget = $total_actual = 0;
		foreach ($budget_sum_arr as $key => $value) {
			$total_budget += $value;
			$total_actual += $actual_sum_arr[$key] == 0 ? $value : $actual_sum_arr[$key];
			$tmp_budget_data[] = $total_budget;
			$tmp_actual_data[] = $total_actual;
		}

		foreach ($data as $key => $value) {
			if ($key == 1) {
				$group = 'PRODUCTION';
			} else {
				$group = 'OFFICE';
			}
			foreach ($value as $key2 => $value2) {
				$show_in_legend = true;
				if ($key2 == 'ACTUAL') {
					$show_in_legend = false;
				}
				$data_final[] = [
					'name' => $group,
					'data' => $value2,
					'stack' => $key2,
					'color' => new JsExpression("Highcharts.getOptions().colors[$key]"),
					'showInLegend' => $show_in_legend
				];
			}
		}

		$data_final[] = [
			'name' => 'Budget Accumulation',
			'data' => $tmp_budget_data,
			'type' => 'line',
			'color' => new JsExpression("Highcharts.getOptions().colors[3]"),
		];
		$data_final[] = [
			'name' => 'Actual Accumulation',
			'data' => $tmp_actual_data,
			'type' => 'line',
			'color' => new JsExpression("Highcharts.getOptions().colors[5]"),
		];

		return $this->render('index', [
			'data' => $data_final,
			'categories' => $categories
		]);
	}
}