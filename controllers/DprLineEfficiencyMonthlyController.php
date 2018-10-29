<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\DprLineEfficiencyView02;
use app\models\DprGmcEffView;
use app\models\SernoLosstime;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use app\models\DprGmcEffView03;

/**
 * 
 */
class DprLineEfficiencyMonthlyController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$line_arr = $this->getLineArr();
		$line = $line_arr[0];
		$year = date('Y');
		$month = date('m');
		

		if (\Yii::$app->request->get('line') !== null) {
			$line = \Yii::$app->request->get('line');
		}

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}

		$period = $year . $month;

		$line_dropdown = ArrayHelper::map(DprLineEfficiencyView02::find()
		->select('DISTINCT(line)')
		->orderBy('line')
		->all(), 'line', 'line');

		$eff_data_arr = DprLineEfficiencyView02::find()
	    ->where([
	    	'period' => $period,
	    	'line' => $line
	    ])
	    ->orderBy('proddate')
	    ->asArray()
	    ->all();

	    $target_eff_arr = [
	    	'306' => 55,
	    	'1600' => 60,
	    	'2700' => 60,
	    	'5600' => 50,
	    	'AW' => 75,
	    	'BR' => 50,
	    	'CEFINE' => 50,
	    	'DBR' => 80,
	    	'DSR' => 50,
	    	'HS' => 90,
	    	'L85' => 110,
	    	'P40' => 80,
	    	'PNT' => 50,
	    	'PTG' => 50,
	    	'SML' => 60,
	    	'SRT' => 50,
	    	'SW' => 60,
	    	'SW2' => 60,
	    	'TB' => 60,
	    	'VX' => 55,
	    	'VX2' => 55,
	    	'XXX' => 100,
	    ];
	    $target_eff = 100;
	    if (isset($target_eff_arr[$line])) {
	    	$target_eff = $target_eff_arr[$line];
	    }

	    $losstime_arr = SernoLosstime::find()
	    ->select([
	    	'proddate',
	    	'losstime' => 'ROUND(SUM(losstime))'
	    ])
	    ->where([
	    	'extract(year_month from proddate)' => $period
	    ])
	    ->andWhere(['<>', 'category', 'UNKNOWN'])
	    ->groupBy('proddate')
	    ->orderBy('proddate')
	    ->asArray()
	    ->all();

	    $tmp_data_losstime = [];
	    foreach ($losstime_arr as $losstime) {
	    	$proddate = (strtotime($losstime['proddate'] . " +7 hours") * 1000);
	    	$tmp_data_losstime[] = [
	    		'x' => $proddate,
	    		'y' => (float)$losstime['losstime']
	    	];
	    }

	    $tmp_data = [];
	    $categories = [];
	    foreach ($eff_data_arr as $eff_data) {
	    	$proddate = (strtotime($eff_data['proddate'] . " +7 hours") * 1000);
	    	$categories[] = $eff_data['proddate'];
	    	$tmp_data[] = [
	    		'x' => $proddate,
	    		'y' => (float)round($eff_data['efficiency']),
		    	//'remark' => $remark,
		    	'url' => Url::to(['dpr-gmc-eff-data/index', 'line' => $line, 'proddate' => $eff_data['proddate']])
	    	];
	    }

	    $data1[] = [
	    	'name' => 'Line Efficiency',
	    	'data' => $tmp_data,
	    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
	    ];

	    $data2[] = [
	    	'name' => 'Line Loss Time',
	    	'data' => $tmp_data_losstime,
	    	'color' => new JsExpression('Highcharts.getOptions().colors[5]'),
	    ];

		return $this->render('index', [
			'data1' => $data1,
			'data2' => $data2,
			'line' => $line,
			'period' => $period,
			'categories' => $categories,
			'line_dropdown' => $line_dropdown,
			'year' => $year,
			'month' => $month,
			'target_eff' => $target_eff,
		]);
	}

	public function getLineArr()
	{
		$data_arr = DprLineEfficiencyView02::find()
		->select('DISTINCT(line)')
		->orderBy('line')
		->all();

		$return_arr = [];

		foreach ($data_arr as $key => $value) {
			$return_arr[] = $value->line;
		}

		return $return_arr;
	}
}