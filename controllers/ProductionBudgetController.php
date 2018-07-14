<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\SalesBudgetTbl;
use app\models\SalesBudgetCompare;
use app\models\Budget;
use yii\web\JsExpression;
use DateTime;
use yii\helpers\Html;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

class ProductionBudgetController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$title = '';
        $subtitle = '';
        $categories = [];
        $prod_category_arr = ['BUDGET', 'FORECAST', 'ACTUAL'];
        $prod_model_arr = [];
        $prod_period_arr = [];
        $prod_bu_arr = [];

        $model = new Budget();
        $model->budget_type = 'ALL';
		$model->qty_or_amount = 'QTY';
        
    	if ($model->load($_POST))
		{

		}

        $tmp_fy = SalesBudgetTbl::find()
        ->where(['PERIOD' => date('Ym')])
        ->one();

        $series = [];

        $prod_sales_arr = SalesBudgetTbl::find()
        ->where([
            'FISCAL' => $tmp_fy->FISCAL,
        ])
        ->all();

        if ($model->budget_type !== 'ALL') {
            $prod_sales_arr = SalesBudgetTbl::find()
            ->where([
                'FISCAL' => $tmp_fy->FISCAL,
                'TYPE' => $model->budget_type
            ])
            ->all();
        }
        

        foreach ($prod_sales_arr as $value) {
            if (!in_array($value->PERIOD, $prod_period_arr)) {
                $prod_period_arr[] = $value->PERIOD;
            }
            if (!in_array($value->BU, $prod_bu_arr)) {
                $prod_bu_arr[] = $value->BU;
            }
        }

        $color_index = 0;

        foreach ($prod_bu_arr as $prod_bu) {
            foreach ($prod_category_arr as $prod_category) {
                $tmp_data = [];
                foreach ($prod_period_arr as $prod_period) {
                    $tmp_qty = 0;
                    foreach ($prod_sales_arr as $prod_sales) {
                        if ($prod_sales->PERIOD == $prod_period && $prod_sales->CATEGORY == $prod_category && $prod_sales->BU == $prod_bu) {
                        	if ($model->qty_or_amount == 'QTY') {
                        		$tmp_qty += $prod_sales->QTY;
                        	} else {
                        		$tmp_qty += $prod_sales->AMOUNT;
                        	}
                        }
                    }
                    $tmp_data[] = [
                        'y' => round($tmp_qty, 2),
                        'remark' => $this->getRemark($prod_period, $model->budget_type, $model->qty_or_amount, $prod_category, $prod_bu)
                    ];
                }
                $series[] = [
                    'name' => $prod_category . ' - ' . $prod_bu,
                    'data' => $tmp_data,
                    'stack' => $prod_category,
                    'color' => new JsExpression('Highcharts.getOptions().colors[' . $color_index . ']'),
                ];
            }
            $color_index++;
        }

        foreach ($prod_period_arr as $value) {
            $date = DateTime::createFromFormat('Ym', $value);
            $categories[] = date_format($date, 'M\' Y');
        }

        return $this->render('index', [
            'model' => $model,
            'title' => $title,
            'subtitle' => $subtitle,
            'categories' => $categories,
            'series' => $series,
            'fiscal' => $tmp_fy->FISCAL,
        ]);
    }

    public function getRemark($period, $product_type, $filter_by, $category, $bu)
    {
        $condition = [
            'PERIOD' => $period,
            //'CATEGORY' => $category,
            'BU' => $bu
        ];

        if (!$product_type == 'ALL') {
            $condition[] = [
                'TYPE' => $product_type
            ];
        }

        $data = '<table class="table table-bordered table-striped table-hover">';

        if ($filter_by == 'QTY') {
            $data .= 
            '<tr class="info">
                <th class="text-center">Model</th>
                <th class="text-center">Qty Budet</th>
                <th class="text-center">Qty Aktual</th>
                <th class="text-center">Qty Balance</th>
            </tr>';
            $orderBy = 'balance_qty';
        } else {
            $data .= 
            '<tr class="info">
                <th class="text-center">Model</th>
                <th class="text-center">Amount Budget</th>
                <th class="text-center">Amount Aktual</th>
                <th class="text-center">Amount Balance</th>
            </tr>';
            $orderBy = 'balance_amount';
        }

        $data_arr = SalesBudgetCompare::find()
        ->select([
            'MODEL' => 'MODEL',
            'total_qty_budget' => 'SUM(QTY_BGT)',
            'total_qty_actual' => 'SUM(QTY_ACT_FOR)',
            'balance_qty' => 'SUM(QTY_BALANCE)',
            'total_amount_budget' => 'SUM(AMOUNT_BGT)',
            'total_amount_actual' => 'SUM(AMOUNT_ACT_FOR)',
            'balance_amount' => 'SUM(AMOUNT_BALANCE)'
        ])
        ->where($condition)
        ->groupBy('model')
        ->orderBy($orderBy)
        ->all();

        foreach ($data_arr as $value) {
            $link = Html::a($value->MODEL, ['group-model-detail', 'period' => $period, 'bu' => $bu, 'product_type' => $product_type, 'product_model' => $value->MODEL, 'filter_by' => $filter_by]);
            if ($filter_by == 'QTY') {
                $data .= '
                    <tr>
                        <td class="text-center">' . $link .'</td>
                        <td class="text-center">' . number_format($value->total_qty_budget) .'</td>
                        <td class="text-center">' . number_format($value->total_qty_actual) .'</td>
                        <td class="text-center">' . number_format($value->balance_qty) .'</td>
                    </tr>
                ';
            } else {
                $data .= '
                    <tr>
                        <td class="text-center">' . $link .'</td>
                        <td class="text-center">' . number_format($value->total_amount_budget) .'</td>
                        <td class="text-center">' . number_format($value->total_amount_actual) .'</td>
                        <td class="text-center">' . number_format($value->balance_amount) .'</td>
                    </tr>
                ';
            }
            
        }

        $data .= '</table>';

        return $data;
        //return $period . ' | ' . $product_type . ' | ' . $filter_by . ' | ' . $category . ' | ' . $bu . ' | ' . $total_qty;
    }

    public function actionGroupModelDetail($period, $bu, $product_type, $product_model, $filter_by)
    {
        $searchModel  = new HrgaSplDataSearch;
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('group-model-detail', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}