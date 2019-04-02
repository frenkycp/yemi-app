<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\AccountBudget;
use app\models\PrReportView;
use app\models\FiscalTbl;

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
		$dept_arr = $this->getDeptArr();

		$model = new \yii\base\DynamicModel([
	        'dept', 'fiscal', 'budget_type'
	    ]);
	    $model->addRule(['dept', 'fiscal', 'budget_type'], 'string');

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
		$model->fiscal = $fiscal;

	    if($model->load(\Yii::$app->request->get())){
	        if ($model->dept != '') {
	        	$dept_arr = [$model->dept];
	        }
	        $fiscal = $model->fiscal;
	    }

	    $categories = $this->getPeriodArr($fiscal);

	    if ($model->dept != '') {
	    	$department = $dept;
	    	if ($model->budget_type != null) {
				$budget_data_arr = AccountBudget::find()
				->select([
					'PERIOD', 'DEP_DESC',
					'BUDGET_AMT' => 'SUM(BUDGET_AMT)',
					'CONSUME_AMT' => 'SUM(CONSUME_AMT)'
				])
				->where([
					'CONTROL' => 'Y',
					'PERIOD' => $categories,
					'FILTER' => $model->budget_type,
					'DEP_DESC' => $dept_arr
				])
				->groupBy('PERIOD, DEP_DESC')
				->asArray()
				->all();
			} else {
				$budget_data_arr = AccountBudget::find()
				->select([
					'PERIOD', 'DEP_DESC',
					'BUDGET_AMT' => 'SUM(BUDGET_AMT)',
					'CONSUME_AMT' => 'SUM(CONSUME_AMT)'
				])
				->where([
					'CONTROL' => 'Y',
					'PERIOD' => $categories,
					'DEP_DESC' => $dept_arr
				])
				->groupBy('PERIOD, DEP_DESC')
				->asArray()
				->all();
			}
	    } else {
	    	$department = 'ALL DEPARTMENT';
	    	if ($model->budget_type != null) {
				$budget_data_arr = AccountBudget::find()
				->select([
					'PERIOD',
					'BUDGET_AMT' => 'SUM(BUDGET_AMT)',
					'CONSUME_AMT' => 'SUM(CONSUME_AMT)'
				])
				->where([
					'CONTROL' => 'Y',
					'PERIOD' => $categories,
					'FILTER' => $model->budget_type
				])
				->groupBy('PERIOD')
				->asArray()
				->all();
			} else {
				$budget_data_arr = AccountBudget::find()
				->select([
					'PERIOD',
					'BUDGET_AMT' => 'SUM(BUDGET_AMT)',
					'CONSUME_AMT' => 'SUM(CONSUME_AMT)'
				])
				->where([
					'CONTROL' => 'Y',
					'PERIOD' => $categories
				])
				->groupBy('PERIOD')
				->asArray()
				->all();
			}
	    }
		
		foreach ($categories as $category) {
			$budget = null;
			$consume = null;
			foreach ($budget_data_arr as $value) {
				if ($value['PERIOD'] == $category) {
					$budget = (int)round($value['BUDGET_AMT']);
					$consume = (int)round($value['CONSUME_AMT']);
				}
			}
			$tmp_data[$department]['BUDGET'][] = [
				'y' => $budget,
				'url' => Url::to(['get-remark', 'dept' => $model->dept, 'period' => $category, 'budget_type' => $model->budget_type])
			];
			$tmp_data[$department]['CONSUME'][] = [
				'y' => $consume,
				'url' => Url::to(['get-remark', 'dept' => $model->dept, 'period' => $category, 'budget_type' => $model->budget_type])
			];
		}

		
		foreach ($tmp_data as $key => $value) {
			$color_index = 0;
			foreach ($value as $key2 => $value2) {
				$showInLegend = $key2 == 'BUDGET' ? false : true;
				$data[] = [
					'name' => $key . " ($key2) ",
					'stack' => $key2,
					'data' => $value2,
					'showInLegend' => $showInLegend,
					'color' => new JsExpression('Highcharts.getOptions().colors[' . $color_index . ']'),
				];
				$color_index++;
			}
			
		}

		return $this->render('index', [
			'data' => $data,
			'categories' => $categories,
			'model' => $model,
			'dept_dropdown' => $this->getDeptArrHelper()
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

	public function getDeptArrHelper()
	{
		$return_arr = ArrayHelper::map(AccountBudget::find()->select('DISTINCT(DEP_DESC)')->orderBy('DEP_DESC ASC')->all(), 'DEP_DESC', 'DEP_DESC');
		return $return_arr;
	}

	public function getPeriodArr($fiscal)
	{
		$tmp_fiscal = FiscalTbl::find()
		->where([
			'FISCAL' => $fiscal
		])
		->orderBy('PERIOD')
		->all();

		$return_arr = [];
		foreach ($tmp_fiscal as $value) {
			$return_arr[] = $value->PERIOD;
		}

		return $return_arr;
	}

	public function actionGetRemark($dept = null, $period, $budget_type = null)
	{
		if ($dept != null) {
			$department = $dept;
		} else {
			$department = 'ALL DEPARTMENT';
		}
		$data = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Section : ' . $department . '<small> (' . $period . ')</small></h3>
		</div>
		<div class="modal-body">
		';
		$data .= '<table class="table table-bordered table-striped table-hover">';
		$data .= 
        '<thead style="font-size: 12px;"><tr class="info">
        	<th>SECTION</th>
            <th>ACCOUNT</th>
            <th>BUDGET</th>
            <th class="text-center">BUDGET</th>
            <th class="text-center">CONSUME</th>
            <th class="text-center">BALANCE</th>
            <th class="text-center">BALANCE (%)</th>
        </tr></thead>';
        $data .= '<tbody style="font-size: 12px;">';

        if ($dept != null) {
        	if ($budget_type != null) {
				$data_arr = AccountBudget::find()
				->where([
					'DEP_DESC' => $dept,
					'CONTROL' => 'Y',
					'PERIOD' => $period,
					'FILTER' => $budget_type
				])
				->orderBy('DEP_DESC ASC')
				->all();
			} else {
				$data_arr = AccountBudget::find()
				->where([
					'DEP_DESC' => $dept,
					'CONTROL' => 'Y',
					'PERIOD' => $period
				])
				->orderBy('DEP_DESC ASC')
				->all();
			}
        } else {
        	if ($budget_type != null) {
				$data_arr = AccountBudget::find()
				->where([
					'CONTROL' => 'Y',
					'PERIOD' => $period,
					'FILTER' => $budget_type
				])
				->orderBy('DEP_DESC ASC')
				->all();
			} else {
				$data_arr = AccountBudget::find()
				->where([
					'CONTROL' => 'Y',
					'PERIOD' => $period
				])
				->orderBy('DEP_DESC ASC')
				->all();
			}
        }
        
		foreach ($data_arr as $value) {
			$balance_percentage = 0;
			if ($value->BUDGET_AMT > 0) {
				$balance_percentage = round(($value->BALANCE_AMT / $value->BUDGET_AMT) * 100);
			}

			$consume_data = $value->CONSUME_AMT;
			if ($consume_data > 0) {
				$consume_data = Html::a(round($value->CONSUME_AMT), Url::to(['pr-report-view/index', 'budget_id' => "$value->BUDGET_ID"]));
			}

			$data .= 
	        '<tr>
	        	<td>' . $value->DEP_DESC . '</td>
	            <td>' . $value->ACCOUNT_DESC . '</td>
	            <td>' . $value->FILTER . '</td>
	            <td class="text-center">' . round($value->BUDGET_AMT) . '</td>
	            <td class="text-center">' . $consume_data . '</td>
	            <td class="text-center">' . round($value->BALANCE_AMT) . '</td>
	            <td class="text-center">' . $balance_percentage . '</td>
	        </tr>';
		}

		$data .= '</tbody>';
        $data .= '</table>';
        $data .= '</div>';

		return $data;
	}
}