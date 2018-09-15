<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\search\ProductionMonthlyFullfillmentSearch;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\SernoOutput;
use app\models\SernoInput;

class ProductionMonthlySummaryController extends Controller
{
    public function actionIndex()
    {
    	$categories = [];
    	$data_open = [];
    	$data_close = [];
		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$fullfillment = SernoOutput::find()
		->select([
			'id',
			'qty' => 'SUM(qty)',
			'output' => 'SUM(output)'
		])
		->groupBy('id')
		->orderBy('id ASC')
		->all();

		foreach ($fullfillment as $key => $value) {
			$categories[] = $value->id;
			$total_open = $value->qty - $value->output;
			$total_close = $value->output;
			$total = $value->qty;

			$presentase_open = round((($total_open / $total) * 100), 1);
			$presentase_close = round((($total_close / $total) * 100), 1);

			$data_open[] = [
				'y' => $total_open > 0 ? $total_open : null,
				'qty' => $total_open
			];
			$data_close[] = [
				'y' => $total_close > 0 ? $total_close : null,
				'qty' => $total_close
			];
		}

		$series = [
			[
				'name' => 'OUTSTANDING',
				'data' => $data_open,
				'color' => 'FloralWhite',
			],
			[
				'name' => 'CLOSE',
				'data' => $data_close,
				'color' => 'rgba(72,61,139,0.6)'
			],
		];

    	return $this->render('index', [
    		'categories' => $categories,
    		'series' => $series,
    	]);
    }

    public function getDelayQty($period)
    {
        $data_arr = SernoInput::find()
        ->joinWith('sernoOutput')
        ->select([
            'total' => 'COUNT(*)'
        ])
        ->where([
            'WEEK(tb_serno_output.ship,4)' => $this->week,
        ])
        ->andWhere('tb_serno_input.proddate > tb_serno_output.etd')
        ->one();

        return $data_arr->total;
    }
}