<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\WipEffDailyUtilView;
use yii\web\JsExpression;

class SmtDailyUtilityReportController extends Controller
{
	public function actionIndex()
	{
		$utility_data_arr = WipEffDailyUtilView::find()
		->where([
			'period' => date('Ym')
		])
		->asArray()
		->all();

		$tmp_data = [];
		foreach ($utility_data_arr as $key => $utility_data) {
			$proddate = (strtotime($utility_data['post_date'] . " +7 hours") * 1000);
			$tmp_data_gross[] = [
	    		'x' => $proddate,
	    		'y' => (float)$utility_data['utility_gross'],
		    	//'url' => Url::to(['dpr-gmc-eff-data/index', 'line' => $line, 'proddate' => $eff_data['proddate']])
	    	];
	    	$tmp_data_nett[] = [
	    		'x' => $proddate,
	    		'y' => (float)$utility_data['utility_nett'],
		    	//'url' => Url::to(['dpr-gmc-eff-data/index', 'line' => $line, 'proddate' => $eff_data['proddate']])
	    	];
		}

		$data = [
			[
		    	'name' => 'SMT Efficiency (Gross)',
		    	'data' => $tmp_data_gross,
		    	'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
		    ],
		    [
		    	'name' => 'SMT Efficiency (Nett)',
		    	'data' => $tmp_data_nett,
		    	'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
		    ],
		];

		return $this->render('index', [
			'data' => $data
		]);
	}
}