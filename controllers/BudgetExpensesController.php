<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;

class BudgetExpensesController extends Controller
{
	
	public function actionIndex()
	{
		$data = [];
		$categories = [];

		$data_source = [
			['201807', 'MIS', 1000, 800],
			['201807', 'Procurement', 2000, 1200],
			['201807', 'Purchasing', 3000, 1800],
			['201808', 'MIS', 1500, 900],
			['201808', 'Procurement', 2500, 1200],
			['201808', 'Purchasing', 3000, 1800],
			['201809', 'MIS', 2000, 1000],
			['201809', 'Procurement', 3000, 1200],
			['201809', 'Purchasing', 3000, 1800],
			['201810', 'MIS', 3000, 2800],
			['201810', 'Procurement', 1000, 800],
			['201810', 'Purchasing', 3000, 1800],
			['201811', 'MIS', 1500, 900],
			['201811', 'Procurement', 5000, 4200],
			['201811', 'Purchasing', 3000, 1800],
			['201812', 'MIS', 2000, 1000],
			['201812', 'Procurement', 4000, 1200],
			['201812', 'Purchasing', 3000, 1800],
		];

		$tmp_data = [];

		foreach ($data_source as $key => $value) {
			if (!in_array($value[0], $categories)) {
				$categories[] = $value[0];
			}
			$tmp_data[$value[1]]['budget'][] = [
				'y' => (int)$value[2],
				'remark' => $this->getRemark(),
			];
			$tmp_data[$value[1]]['actual'][] = [
				'y' => (int)$value[3],
				'remark' => $this->getRemark(),
			];
		}

		$color_index = 0;
		foreach ($tmp_data as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$showInLegend = $key2 == 'actual' ? false : true;
				$data[] = [
					'name' => $key,
					'stack' => $key2,
					'data' => $value2,
					'showInLegend' => $showInLegend,
					'color' => new JsExpression('Highcharts.getOptions().colors[' . $color_index . ']'),
				];
			}
			$color_index++;
		}

		return $this->render('index', [
			'data' => $data,
			'categories' => $categories
		]);
	}

	public function getRemark()
	{
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
        '<thead style="font-size: 12px;"><tr class="info">
            <th class="text-center">VENDOR</th>
            <th class="text-center">IMR</th>
            <th class="text-center">NO</th>
            <th class="text-center">ITEM</th>
            <th class="text-center">DESC</th>
            <th class="text-center">UOM</th>
            <th class="text-center">DATE</th>
            <th class="text-center">AMOUNT(USD)</th>
            <th class="text-center">BY</th>
            <th class="text-center">DEP</th>
            <th class="text-center">REMARK</th>
        </tr></thead>';
        $data .= '</table>';

		return $data;
	}
}