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
use app\models\search\GroupModelDetailSearch;

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

        $sales_data_compare = SalesBudgetCompare::find()
        ->select([
            'FISCAL' => 'FISCAL',
            'PERIOD' => 'PERIOD',
            'total_amount_budget' => 'SUM(AMOUNT_BGT)',
            'total_amount_actual' => 'SUM(AMOUNT_ACT_FOR)'
        ])
        ->where([
            'FISCAL' => $tmp_fy->FISCAL,
            //'FISCAL' => $this->getPeriodFiscal(date('Ym'))
        ])
        ->groupBy('FISCAL, PERIOD')
        ->orderBy('PERIOD')
        ->all();

        if ($model->budget_type !== 'ALL') {
            $prod_sales_arr = SalesBudgetTbl::find()
            ->where([
                'FISCAL' => $tmp_fy->FISCAL,
                'TYPE' => $model->budget_type
            ])
            ->all();

            $sales_data_compare = SalesBudgetCompare::find()
            ->select([
                'FISCAL' => 'FISCAL',
                'PERIOD' => 'PERIOD',
                'total_amount_budget' => 'SUM(AMOUNT_BGT)',
                'total_amount_actual' => 'SUM(AMOUNT_ACT_FOR)'
            ])
            ->where([
                'FISCAL' => $tmp_fy->FISCAL,
                'TYPE' => $model->budget_type
                //'FISCAL' => $this->getPeriodFiscal(date('Ym'))
            ])
            ->groupBy('FISCAL, PERIOD')
            ->orderBy('PERIOD')
            ->all();
        }

        $budget_grandtotal_amount = 0;
        $actual_grandtotal_amount = 0;

        $tmp_data_amount_budget = [];
        $tmp_data_amount_actual = [];
        foreach ($sales_data_compare as $value) {
            $budget_grandtotal_amount += $value->total_amount_budget;
            $actual_grandtotal_amount += $value->total_amount_actual;
            $tmp_data_amount_budget[] = [
                'y' => round($budget_grandtotal_amount),
                'remark' => ''
            ];
            $tmp_data_amount_actual[] = [
                'y' => round($actual_grandtotal_amount),
                'remark' => ''
            ];
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
                $sp_line_data = [];
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
                        'y' => $tmp_qty == 0 ? null : round($tmp_qty),
                        'remark' => $this->getRemark($prod_period, $model->budget_type, $model->qty_or_amount, $prod_bu)
                    ];
                }
                $series[] = [
                    'type' => 'column',
                    'name' => $prod_category . ' - ' . $prod_bu,
                    'data' => $tmp_data,
                    'stack' => $prod_category,
                    'color' => new JsExpression('Highcharts.getOptions().colors[' . $color_index . ']'),
                    'showInLegend' => false,
                    'cursor' => 'pointer',
                    'point' => [
                        'events' => [
                            'click' => new JsExpression('
                                function(){
                                    $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                }
                            '),
                        ]
                    ]
                ];
            }
            $color_index++;
        }

        if ($model->qty_or_amount == 'AMOUNT') {
            $series[] = [
                'type' => 'spline',
                'name' => 'Budget Amount (予算金額)',
                'data' => $tmp_data_amount_budget,
                'yAxis' => 1,
                'color' => new JsExpression('Highcharts.getOptions().colors[7]'),
                'marker' => [
                    'lineWidth' => 1,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[5]'),
                    'fillColor' => 'white'
                ]
            ];

            $series[] = [
                'type' => 'spline',
                'name' => 'Actual Amount (見込/実績金額)',
                'data' => $tmp_data_amount_actual,
                'yAxis' => 2,
                'color' => new JsExpression('Highcharts.getOptions().colors[6]'),
                'marker' => [
                    'lineWidth' => 1,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[4]'),
                    'fillColor' => 'white'
                ]
            ];
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
            'budget_grandtotal_amount' => $budget_grandtotal_amount,
            'actual_grandtotal_amount' => $actual_grandtotal_amount,
            'fiscal' => $tmp_fy->FISCAL,
            'tmp_data_amount_budget' => $tmp_data_amount_budget,
            'last_update' => date('d M\' Y', strtotime($tmp_fy->LAST_UPDATE))
        ]);
    }

    public function getPeriodFiscal($period)
    {
        $data = SalesBudgetTbl::find()
        ->where([
            'PERIOD' => $period
        ])
        ->one();

        return $data->FISCAL;
    }

    public function getRemark($period, $product_type, $filter_by, $bu)
    {
        $condition = [
            'PERIOD' => $period,
            'BU' => $bu
        ];

        if ($bu == 'ALL') {
            $condition = [
                'PERIOD' => $period
            ];
        }

        if (!$product_type == 'ALL') {
            $condition[] = [
                'TYPE' => $product_type
            ];
        }

        $data = '<table class="table table-bordered table-striped table-hover">';

        if ($filter_by == 'QTY') {
            $data .= 
            '<tr class="info">
                <th class="text-center">No</th>
                <th class="text-center">Periode</th>
                <th class="text-center">Model</th>
                <th class="text-center">Budget Qty<br/>(予算数量)</th>
                <th class="text-center">Act/Forecast Qty<br/>(見込み/実績)</th>
                <th class="text-center">Balance Qty<br/>(対予算)</th>
                <th class="text-center">Balance Qty<br/>(対予算)</th>
            </tr>';
            $orderBy = 'balance_qty';
        } else {
            $data .= 
            '<tr class="info">
                <th class="text-center">No</th>
                <th class="text-center">Periode</th>
                <th class="text-center">Model</th>
                <th class="text-center">Budget Amount<br/>(予算金額)</th>
                <th class="text-center">Act/Forecast Amount<br/>(見込み/実績)</th>
                <th class="text-center">Balance Amount<br/>(対予算)</th>
                <th class="text-center">Balance Amount<br/>(対予算)</th>
            </tr>';
            $orderBy = 'balance_amount';
        }

        $data_arr = SalesBudgetCompare::find()
        ->select([
            'PERIOD' => 'PERIOD',
            'MODEL' => 'MODEL',
            'total_qty_budget' => 'SUM(QTY_BGT)',
            'total_qty_actual' => 'SUM(QTY_ACT_FOR)',
            'balance_qty' => 'SUM(QTY_BALANCE)',
            'total_amount_budget' => 'SUM(AMOUNT_BGT)',
            'total_amount_actual' => 'SUM(AMOUNT_ACT_FOR)',
            'balance_amount' => 'SUM(AMOUNT_BALANCE)'
        ])
        ->where($condition)
        ->groupBy('PERIOD, MODEL')
        ->orderBy($orderBy)
        ->all();

        $i = 1;
        foreach ($data_arr as $value) {
            $link = Html::a($value->MODEL, ['group-model-detail', 'period' => $period, 'bu' => $bu, 'product_type' => $product_type, 'product_model' => $value->MODEL, 'filter_by' => $filter_by], ['target' => '_blank']);
            $percentage = 0;
            if ($filter_by == 'QTY') {
                if ($value->total_qty_budget != 0) {
                    $percentage = round(($value->total_qty_actual / $value->total_qty_budget) * 100);
                }
                $data .= '
                    <tr>
                        <td class="text-center">' . $i .'</td>
                        <td class="text-center">' . $value->PERIOD .'</td>
                        <td class="text-center">' . $link .'</td>
                        <td class="text-center">' . number_format($value->total_qty_budget) .'</td>
                        <td class="text-center">' . number_format($value->total_qty_actual) .'</td>
                        <td class="text-center">' . number_format($value->balance_qty) .'</td>
                        <td class="text-center">' . $percentage .'%</td>
                    </tr>
                ';
            } else {
                if ($value->total_amount_budget != 0) {
                    $percentage = round(($value->total_amount_actual / $value->total_amount_budget) * 100);
                }
                $data .= '
                    <tr>
                        <td class="text-center">' . $i .'</td>
                        <td class="text-center">' . $value->PERIOD .'</td>
                        <td class="text-center">' . $link .'</td>
                        <td class="text-center">' . number_format($value->total_amount_budget) .'</td>
                        <td class="text-center">' . number_format($value->total_amount_actual) .'</td>
                        <td class="text-center">' . number_format($value->balance_amount) .'</td>
                        <td class="text-center">' . $percentage .'%</td>
                    </tr>
                ';
            }
            $i++;
        }

        $data .= '</table>';

        return $data;
        //return $period . ' | ' . $product_type . ' | ' . $filter_by . ' | ' . $category . ' | ' . $bu . ' | ' . $total_qty;
    }

    public function actionGroupModelDetail($period, $bu, $product_type, $product_model, $filter_by)
    {
        $searchModel  = new GroupModelDetailSearch;
        $searchModel->PERIOD = $period;
        $searchModel->BU = $bu;
        if ($product_type !== 'ALL') {
            $searchModel->TYPE = $product_type;
        }
        
        $searchModel->MODEL = $product_model;

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