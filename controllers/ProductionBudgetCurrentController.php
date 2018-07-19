<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\SalesBudgetCompare;
use yii\web\JsExpression;
use DateTime;
use yii\helpers\Html;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

class ProductionBudgetCurrentController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		$period = date('Ym');
		$compare_data_arr = SalesBudgetCompare::find()
		->select([
			'PERIOD' => 'PERIOD',
			'BU' => 'BU',
			'total_amount_budget' => 'SUM(AMOUNT_BGT)',
			'total_amount_forecast' => 'SUM(AMOUNT_ACT_FOR)',
			'total_amount_current' => 'SUM(AMOUNT_CUR)'
		])
		->where([
			'PERIOD' => $period
		])
		->groupBy('PERIOD, BU')
		->orderBy('BU')
		->all();

		$tmp_data_budget = [];
		$tmp_data_act_for = [];
		$tmp_data_current = [];
		$categories = [];
		$data2 = [];
		$color_index = 0;
		foreach ($compare_data_arr as $compare_data) {
			$categories[] = $compare_data->BU;
			$tmp_data_budget[] = [
				'y' => round($compare_data->total_amount_budget),
				'remark' => $this->getRemark($period, $compare_data->BU)
			];
			$tmp_data_act_for[] = [
				'y' => round($compare_data->total_amount_forecast),
				'remark' => $this->getRemark($period, $compare_data->BU)
			];
			$tmp_data_current[] = [
				'y' => round($compare_data->total_amount_current),
				'remark' => $this->getRemark($period, $compare_data->BU)
			];

			$data2[] = [
				'name' => 'BUDGET - ' . $compare_data->BU,
				'data' => [
					[
						'y' => round($compare_data->total_amount_budget),
						'remark' => $this->getRemark($period, $compare_data->BU)
					]
				],
				'stack' => 'BUDGET',
				'color' => new JsExpression('Highcharts.getOptions().colors[' . $color_index . ']'),
			];

			$data2[] = [
				'name' => 'FORECAST - ' . $compare_data->BU,
				'data' => [
					[
						'y' => round($compare_data->total_amount_forecast),
						'remark' => $this->getRemark($period, $compare_data->BU)
					]
				],
				'stack' => 'FORECAST',
				'color' => new JsExpression('Highcharts.getOptions().colors[' . $color_index . ']'),
			];

			$data2[] = [
				'name' => 'CURRENT - ' . $compare_data->BU,
				'data' => [
					[
						'y' => round($compare_data->total_amount_current),
						'remark' => $this->getRemark($period, $compare_data->BU)
					]
				],
				'stack' => 'CURRENT',
				'color' => new JsExpression('Highcharts.getOptions().colors[' . $color_index . ']'),
			];

			$color_index++;

		}

		$data = [
			[
				'name' => 'BUDGET',
				'data' => $tmp_data_budget
			],
			[
				'name' => 'FORECAST',
				'data' => $tmp_data_act_for
			],
			[
				'name' => 'CURRENT',
				'data' => $tmp_data_current
			],
		];


		return $this->render('index',[
			'data' => $data,
			'data2'=> $data2,
			'period' => $period,
			'categories' => $categories
		]);
	}

	public function getRemark($period, $bu)
    {
        $condition = [
            'PERIOD' => $period,
            'BU' => $bu
        ];

        $data = '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<tr class="info">
            <th class="text-center">Periode</th>
            <th class="text-center">Model</th>
            <th class="text-center">Budget Amount<br/>(予算金額)</th>
            <th class="text-center">Forecast Amount<br/>(見込み)</th>
            <th class="text-center">Current Amount<br/>(実績金額)</th>
            <th class="text-center">TO BUDGET<br/>(対予算）</th>
            <th class="text-center">TO BUDGET (%)<br/>(対予算）</th>
        </tr>';

        $data_arr = SalesBudgetCompare::find()
        ->select([
            'PERIOD' => 'PERIOD',
            'BU' => 'BU',
            'MODEL' => 'MODEL',
            'total_amount_budget' => 'SUM(AMOUNT_BGT)',
            'total_amount_actual' => 'SUM(AMOUNT_ACT_FOR)',
            'total_amount_current' => 'SUM(AMOUNT_CUR)',
            'balance_amount' => 'SUM(AMOUNT_CUR) - SUM(AMOUNT_BGT)'
        ])
        ->where($condition)
        ->groupBy('PERIOD, BU, MODEL')
        ->orderBy('balance_amount')
        ->all();

        $i = 1;
        foreach ($data_arr as $value) {
            $link = Html::a($value->MODEL, ['group-model-detail', 'period' => $period, 'bu' => $bu, 'product_type' => 'ALL', 'product_model' => $value->MODEL, 'filter_by' => 'AMOUNT'], ['target' => '_blank']);
            
            $current_percentage = 0;
            if ($value->total_amount_budget > 0) {
            	$current_percentage = round(($value->total_amount_current / $value->total_amount_budget) * 100);
            }
            $data .= '
                <tr>
                    <td class="text-center">' . $value->PERIOD .'</td>
                    <td class="text-center">' . $value->MODEL .'</td>
                    <td class="text-center">' . number_format($value->total_amount_budget) .'</td>
                    <td class="text-center">' . number_format($value->total_amount_actual) .'</td>
                    <td class="text-center">' . number_format($value->total_amount_current) .'</td>
                    <td class="text-center">' . number_format($value->balance_amount) .'</td>
                    <td class="text-center">' . $current_percentage .'%</td>
                </tr>
            ';
            $i++;
        }

        $data .= '</table>';

        return $data;
        //return $period . ' | ' . $product_type . ' | ' . $filter_by . ' | ' . $category . ' | ' . $bu . ' | ' . $total_qty;
    }
}