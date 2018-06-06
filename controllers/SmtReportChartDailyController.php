<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\JobOrderView4 as SmtReport;

/**
 * summary
 */
class SmtReportChartDailyController extends Controller
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$data = [];
    	$loc = [];

    	$tmp_loc = SmtReport::find()->select([
    		'loc' => 'DISTINCT(LOC)'
    	])->all();

    	foreach ($tmp_loc as $value) {
    		$loc[] = $value->loc;
    	}

    	$smt_report = SmtReport::find()
    	->where([
    		'PERIOD' => date('Ym'),
    	])
    	->orderBy('DATE ASC')
    	->all();

		foreach ($smt_report as $value) {
			$location = trim($value->LOC);
			$data[$location]['category'][] = $value->DATE;
			$data[$location]['utilization'][] = $value->UTILIZATION;
			$data[$location]['eficiency'][] = $value->EFFICIENCY;
		}

    	return $this->render('index', [
    		'data' => $data,
    		'loc' => $loc,
    	]);
    }
}