<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SalesBudgetTbl;
use yii\web\JsExpression;
use DateTime;

/**
 * summary
 */
class ProductionSalesQtyController extends Controller
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

    	$tmp_fy = SalesBudgetTbl::find()
        ->where([
            'PERIOD' => date('Ym'),
        ])
        ->one();

    	$series = [];

    	$prod_sales_arr = SalesBudgetTbl::find()
        ->where([
            'FISCAL' => $tmp_fy->FISCAL,
            'TYPE' => 'PRODUCT'
        ])
        ->all();

    	foreach ($prod_sales_arr as $value) {
    		/*if (!in_array($value->CATEGORY, $prod_category_arr)) {
    			$prod_category_arr[] = $value->CATEGORY;
    		}
    		if (!in_array($value->MODEL, $prod_model_arr)) {
    			$prod_model_arr[] = $value->MODEL;
    		}*/
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
                            $tmp_qty += $prod_sales->QTY;
                        }
    				}
    				$tmp_data[] = (int)$tmp_qty;
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
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'categories' => $categories,
    		'series' => $series,
            'fiscal' => $tmp_fy->FISCAL,
    	]);
    }
}