<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\AccountBudget;
use app\models\PrReportView;

class BudgetExpensesController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex()
	{
		$data = [];
		$tmp_data = [];
		$categories = $this->getPeriodArr('201804', '201903');
		$dept_arr = $this->getDeptArr();

		foreach ($dept_arr as $dept) {
			foreach ($categories as $category) {
				$budget_data = AccountBudget::find()
				->select([
					'BUDGET_AMT' => 'SUM(BUDGET_AMT)',
					'CONSUME_AMT' => 'SUM(CONSUME_AMT)'
				])
				->where([
					'CONTROL' => 'Y',
					'PERIOD' => $category,
					'DEP_DESC' => $dept
				])
				->one();
				$remark = $this->getRemark($dept, $category);
				$tmp_data[$dept]['BUDGET'][] = [
					'y' => (int)$budget_data->BUDGET_AMT,
					'remark' => $remark,
				];
				$tmp_data[$dept]['CONSUME'][] = [
					'y' => (int)$budget_data->CONSUME_AMT,
					'remark' => $remark,
				];
			}
		}

		$color_index = 0;
		foreach ($tmp_data as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$showInLegend = $key2 == 'BUDGET' ? false : true;
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

	public function getDeptArr()
	{
		$data_arr = AccountBudget::find()->select('DISTINCT(DEP_DESC)')->orderBy('DEP_DESC ASC')->all();
		$return_arr = [];
		foreach ($data_arr as $value) {
			$return_arr[] = $value->DEP_DESC;
		}

		return $return_arr;
	}

	public function getPeriodArr($min_period, $max_period)
	{
		$data_arr = AccountBudget::find()
		->select('DISTINCT(PERIOD)')
		->where(['>=', 'PERIOD', $min_period])
		->andWhere(['<=', 'PERIOD', $max_period])
		->orderBy('PERIOD ASC')
		->all();

		$return_arr = [];
		foreach ($data_arr as $value) {
			$return_arr[] = $value->PERIOD;
		}

		return $return_arr;
	}

	public function getRemark($dept, $period)
	{
		$data = "<h4>$dept<small> ($period)</small></h4>";
		$data .= '<table class="table table-bordered table-striped table-hover">';
		$data .= 
        '<thead style="font-size: 12px;"><tr class="info">
            <th>ACCOUNT</th>
            <th class="text-center">BUDGET</th>
            <th class="text-center">CONSUME</th>
            <th class="text-center">BALANCE</th>
            <th class="text-center">BALANCE (%)</th>
        </tr></thead>';
        $data .= '<tbody style="font-size: 12px;">';

        $data_arr = AccountBudget::find()
		->where([
			'DEP_DESC' => $dept,
			'CONTROL' => 'Y',
			'PERIOD' => $period
		])
		->orderBy('CONSUME_AMT DESC')
		->all();

		foreach ($data_arr as $value) {
			$balance_percentage = 0;
			if ($value->BUDGET_AMT > 0) {
				$balance_percentage = round(($value->BALANCE_AMT / $value->BUDGET_AMT) * 100);
			}

			$consume_data = $value->CONSUME_AMT;
			if ($consume_data > 0) {
				$consume_data = Html::a($value->CONSUME_AMT, Url::to(['pr-report-view/index', 'budget_id' => "$value->BUDGET_ID"]));
			}

			$data .= 
	        '<tr>
	            <td>' . $value->ACCOUNT_DESC . '</td>
	            <td class="text-center">' . $value->BUDGET_AMT . '</td>
	            <td class="text-center">' . $consume_data . '</td>
	            <td class="text-center">' . $value->BALANCE_AMT . '</td>
	            <td class="text-center">' . $balance_percentage . '</td>
	        </tr>';
		}

		$data .= '</tbody>';
        $data .= '</table>';

		return $data;
	}
}