<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\PoRcvBgtVsAct04;
use app\models\PrReportView;

class BudgetExpensesAccController extends Controller
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

		$model = new \yii\base\DynamicModel([
	        'dept'
	    ]);
	    $model->addRule('dept', 'string');

	    if($model->load(\Yii::$app->request->get())){
	        $dept_arr = [$model->dept];
	    }

	    $budget_data_arr = PoRcvBgtVsAct04::find()
		->select([
			'DEP_DESC',
			'PERIOD',
			'BUDGET_AMT' => 'SUM(BUDGET_AMT)',
			'CONSUME_AMT' => 'SUM(CONSUME_AMT)'
		])
		->where([
			'CONTROL' => 'Y'
		])
		->groupBy('PERIOD, DEP_DESC')
		->all();

		$remark_data_arr = PoRcvBgtVsAct04::find()
		->where([
			'CONTROL' => 'Y'
		])
		->orderBy('CONSUME_AMT DESC')
		->all();

		foreach ($dept_arr as $dept) {
			foreach ($categories as $category) {
				$budget = 0;
				$consume = 0;
				foreach ($budget_data_arr as $budget_data) {
					if ($budget_data->DEP_DESC == $dept && $budget_data->PERIOD == $category) {
						$budget = $budget_data->BUDGET_AMT;
						$consume = $budget_data->CONSUME_AMT;
					}
				}

				$remark = "<h4>$dept<small> ($category)</small></h4>";
				$remark .= '<table class="table table-bordered table-striped table-hover">';
				$remark .= 
		        '<thead style="font-size: 12px;"><tr class="info">
		            <th>ACCOUNT</th>
		            <th class="text-center">BUDGET</th>
		            <th class="text-center">CONSUME</th>
		            <th class="text-center">BALANCE</th>
		            <th class="text-center">BALANCE (%)</th>
		        </tr></thead>';
		        $remark .= '<tbody style="font-size: 12px;">';

		        foreach ($remark_data_arr as $value) {
					if ($value->DEP_DESC == $dept && $value->PERIOD == $category) {
						$balance_percentage = 0;
						if ($value->BUDGET_AMT > 0) {
							$balance_percentage = round(($value->BALANCE_AMT / $value->BUDGET_AMT) * 100);
						}

						$consume_data = $value->CONSUME_AMT;
						if ($consume_data > 0) {
							$consume_data = Html::a($value->CONSUME_AMT, Url::to(['budget-expenses-acc-detail-data/index', 'budget_id' => "$value->BUDGET_ID"]));
						}

						$remark .= 
				        '<tr>
				            <td>' . $value->ACCOUNT_DESC . '</td>
				            <td class="text-center">' . $value->BUDGET_AMT . '</td>
				            <td class="text-center">' . $consume_data . '</td>
				            <td class="text-center">' . $value->BALANCE_AMT . '</td>
				            <td class="text-center">' . $balance_percentage . '</td>
				        </tr>';
					}
				}

				$remark .= '</tbody>';
		        $remark .= '</table>';

				$tmp_data[$dept]['BUDGET'][] = [
					'y' => (int)$budget,
					'remark' => $remark,
				];
				$tmp_data[$dept]['CONSUME'][] = [
					'y' => (int)$consume,
					'remark' => $remark,
				];
			}
		}

		$color_index = 0;
		foreach ($tmp_data as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$showInLegend = $key2 == 'BUDGET' ? false : true;
				if (count($dept_arr) == 1) {
					$color = new JsExpression('Highcharts.getOptions().colors[1]');
				} else {
					$color = new JsExpression('Highcharts.getOptions().colors[' . $color_index . ']');
				}
				$data[] = [
					'name' => $key,
					'stack' => $key2,
					'data' => $value2,
					'showInLegend' => $showInLegend,
					'color' => $color,
				];
			}
			$color_index++;
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
		$data_arr = PoRcvBgtVsAct04::find()->select('DISTINCT(DEP_DESC)')->orderBy('DEP_DESC ASC')->all();
		$return_arr = [];
		foreach ($data_arr as $value) {
			$return_arr[] = $value->DEP_DESC;
		}

		return $return_arr;
	}

	public function getDeptArrHelper()
	{
		$return_arr = ArrayHelper::map(PoRcvBgtVsAct04::find()->select('DISTINCT(DEP_DESC)')->orderBy('DEP_DESC ASC')->all(), 'DEP_DESC', 'DEP_DESC');
		return $return_arr;
	}

	public function getPeriodArr($min_period, $max_period)
	{
		$data_arr = PoRcvBgtVsAct04::find()
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

        $data_arr = PoRcvBgtVsAct04::find()
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
				$consume_data = Html::a($value->CONSUME_AMT, Url::to(['budget-expenses-acc-detail-data/index', 'budget_id' => "$value->BUDGET_ID"]));
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