<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\ProductionInspection;
use app\models\SernoCalendar;

class ProductionInspectionChartController extends Controller
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
		$data = [];

		date_default_timezone_set('Asia/Jakarta');

    	$min_max_week = ProductionInspection::find()
    	->select([
    		'tahun' => 'LEFT(proddate,4)',
    		'min_week' => 'MIN(week_no)',
    		'max_week' => 'MAX(week_no)'
    	])
    	->where(['LEFT(proddate,4)' => date('Y')])
    	->groupBy('tahun')
    	->one();

    	$weekToday = SernoCalendar::find()->where(['ship' => date('Y-m-d')])->one()->week_ship;

		$start_week = 1;
		$end_week = 52;

		if(count($min_max_week) > 0)
		{
			$start_week = $min_max_week->min_week;
			$end_week = $min_max_week->max_week;
		}

		/*$sernoFg = ProductionInspection::find()
        ->select([
        	'week_no' => 'week_no',
            'proddate' => 'proddate',
            'qa_ok' => 'qa_ok',
            'total' => 'COUNT(qa_ok)'
        ])
        ->where([
            'LEFT(proddate,4)' => date('Y'),
        ])
        ->groupBy('week_no, proddate, qa_ok')
        ->all();*/

        $data = [];

		for ($i = $start_week; $i <= $end_week; $i++) {
			
		}

		return $this->render('index', [
			'title' => $title,
			'subtitle' => $subtitle,
			'weekToday' => $weekToday,
        	'startWeek' => $start_week,
        	'endWeek' => $end_week
		]);
	}
}