<?php

namespace app\controllers;

use yii\web\Controller;
use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\SplViewActVsBgt03;
use app\models\FiscalTbl;
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
		$year = date('Y');
		$fiscal = FiscalTbl::find()
		->select('FISCAL')
		->where([
			'PERIOD' => date('Ym')
		])
		->one()
		->FISCAL;
		if ($fiscal == null) {
			$fiscal = FiscalTbl::find()
			->select([
				'FISCAL' => 'MAX(FISCAL)'
			])
			->one()
			->FISCAL;
		}

		if (\Yii::$app->request->get('fiscal') !== null) {
			$fiscal = \Yii::$app->request->get('fiscal');
		}

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		$period_data_arr = FiscalTbl::find()
		->select('PERIOD')
		->where([
			'FISCAL' => $fiscal
		])
		->orderBy('PERIOD')
		->asArray()
		->all();

		foreach ($period_data_arr as $period_data) {
			$period = $period_data['PERIOD'];
			$categories[] = $period;

			$tmp_sum_budget = 0;
			$tmp_sum_actual = 0;
			for ($j = 1; $j < 3; $j++) {
				$budget = 0;
				$actual = 0;
				$spl_data = SplViewActVsBgt03::find()
				->where([
					'PERIOD' => $period,
					'DIVISION' => $j
				])
				->one();

				if ($spl_data->PERIOD != null) {
					$budget = (double)$spl_data->BUDGET;
					$actual = (double)$spl_data->ACTUAL;
				}
				/*foreach ($spl_data_arr as $value) {
					if ($value->DIVISION == $j && $value->PERIOD == $period) {
						$budget = (double)$value->BUDGET;
						$actual = (double)$value->ACTUAL;
					}
				}*/
				if ($budget == 0) {
					$budget = null;
				}
				$data[$j]['BUDGET'][] = $budget;
				$data[$j]['ACTUAL'][] = $actual == 0 ? $budget : $actual;
				$tmp_sum_budget += $budget;
				$tmp_sum_actual += $actual;
			}
			$budget_sum_arr[$period] = $tmp_sum_budget;
			$actual_sum_arr[$period] = $tmp_sum_actual;
		}

		for ($i = 1; $i <= 12; $i++) {
			
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
				$group = 'Production (生産系)';
			} else {
				$group = 'Office (事務系)';
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
			'name' => 'Budget Accum (予算累計)',
			'data' => $tmp_budget_data,
			'type' => 'line',
			'color' => new JsExpression("Highcharts.getOptions().colors[3]"),
		];
		$data_final[] = [
			'name' => 'Forecast Accum (見込み累計)',
			'data' => $tmp_actual_data,
			'type' => 'line',
			'color' => new JsExpression("Highcharts.getOptions().colors[5]"),
		];

		return $this->render('index', [
			'data' => $data,
			'data_final' => $data_final,
			'categories' => $categories,
			'year' => $year,
			'fiscal' => $fiscal,
		]);
	}
}