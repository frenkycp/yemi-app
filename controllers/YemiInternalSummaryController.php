<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoCalendar;
use app\models\SernoOutput;

class YemiInternalSummaryController extends Controller
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');

    	$min_max_week = SernoOutput::find()
    	->select([
    		'tahun' => 'LEFT(id,4)',
    		'min_week' => 'MIN(WEEK(ship,4))',
    		'max_week' => 'MAX(WEEK(ship,4))'
    	])
    	->where(['<>', 'stc', 'ADVANCE'])
    	->andWhere(['LEFT(id,4)' => date('Y')])
    	->groupBy('tahun')
    	->one();

    	$weekToday = SernoCalendar::find()->where(['etd' => date('Y-m-d')])->one()->week_ship;

		$start_week = 1;
		$end_week = 52;

		if(count($min_max_week) > 0)
		{
			$start_week = $min_max_week->min_week;
			$end_week = $min_max_week->max_week;
		}
		return $this->render('index', [
        	'weekToday' => $weekToday,
        	'startWeek' => $start_week,
        	'endWeek' => $end_week
        ]);
	}
}