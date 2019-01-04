<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\DprLineEff02;
use app\models\DprLineEfficiencyView02;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * 
 */
class DprLineEffTargetActualController extends Controller
{
	
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		$data = [];
		$year = date('Y');
		$month = date('m');
		$tanggal = date('Y-m-d');

		if (\Yii::$app->request->get('tanggal') !== null) {
			$tanggal = \Yii::$app->request->get('tanggal');
		}

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
	    /*
	    $eff_data_arr = DprLineEff02::find()
	    ->where([
	    	'period' => $period
	    ])
	    ->all();

	    foreach ($eff_data_arr as $value) {
	    	$line = $value->line;
	    	
	    	if (isset($target_eff_arr[$line])) {
	    		$target_eff = $target_eff_arr[$line];
	    	} else {
	    		$target_eff = 100;
	    	}

	    	if ($value->eff == null) {
	    		$act_eff = 0;
	    	} else {
	    		$act_eff = $value->eff;
	    	}

	    	$compare = 0;
	    	if ($act_eff > 0) {
	    		$compare = round(($target_eff / $act_eff) * 100, 2);
	    	}
	    	

	    	$tmp_data[$line] = $compare;
	    }

	    asort($tmp_data);

	    foreach ($tmp_data as $key => $value) {
	    	$categories[] = $key;
	    	$tmp_data2[] = [
	    		'y' => $value
	    	];
	    }
	    $data[] = [
	    	'name' => 'Target v.s Actual Efficiency',
	    	'data' => $tmp_data2,
	    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
	    ]; */

	    $eff_data_arr2 = DprLineEfficiencyView02::find()
	    ->where([
	    	'proddate' => $tanggal
	    ])
	    ->all();

	    $daily_tmp_data = [];
	    foreach ($eff_data_arr2 as $value) {
	    	$line = $value->line;
	    	
	    	if (isset($target_eff_arr[$line])) {
	    		$target_eff = $target_eff_arr[$line];
	    	} else {
	    		$target_eff = 100;
	    	}

	    	if ($value->efficiency == null) {
	    		$act_eff = 0;
	    	} else {
	    		$act_eff = $value->efficiency;
	    	}

	    	$compare = 0;
	    	if ($act_eff > 0) {
	    		$compare = round(($target_eff / $act_eff) * 100, 2);
	    	}
	    	$daily_tmp_data[$line] = $compare;
	    }

	    asort($daily_tmp_data);

	    foreach ($daily_tmp_data as $key => $value) {
	    	$daily_categories[] = $key;
	    	$daily_tmp_data2[] = [
	    		'y' => $value
	    	];
	    }

	    $daily_data[] = [
	    	'name' => 'Target v.s Actual Efficiency',
	    	'data' => $daily_tmp_data2,
	    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
	    ];

		return $this->render('index', [
			/*'data' => $data,
			'categories' => $categories,*/
			'daily_data' => $daily_data,
			'daily_categories' => $daily_categories,
			'tanggal' => $tanggal,
		]);
	}
}