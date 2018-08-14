<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\WipFlowView02;
use yii\web\JsExpression;

class WipFlowProcessMonitoringController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$categories = [];
    	$wip_data_arr = WipFlowView02::find()
    	->select([
    		'period',
    		'child_analyst',
    		'child_analyst_desc',
    		'start_date' => 'MIN(due_date)',
    		'end_date' => 'MAX(due_date)',
    		'plan_qty' => 'SUM(plan_qty)',
    		'act_qty' => 'SUM(act_qty)'
    	])
    	->groupBy('period, child_analyst, child_analyst_desc')
    	->all();

    	$tmp_data = [];
    	$index = 0;
    	foreach ($wip_data_arr as $value) {
    		$categories[] = $value->child_analyst_desc;
    		$start_date = date('Y-n-d', strtotime($value->start_date));
    		$start_date_split = explode('-', $start_date);
    		$end_date = date('Y-n-d', strtotime($value->end_date));
    		$end_date_split = explode('-', $end_date);
    		$presentase = 0;
    		if ($value->plan_qty > 0) {
    			$presentase = round(($value->act_qty / $value->plan_qty), 2);
    		}
    		$tmp_data[] = [
    			'x' => new JsExpression('Date.UTC(' . json_encode($start_date_split[0]) . ', ' . json_encode($start_date_split[1] - 1) . ', ' . json_encode($start_date_split[2]) . ')'),
    			'x2' => new JsExpression('Date.UTC(' . json_encode($end_date_split[0]) . ', ' . json_encode($end_date_split[1] - 1) . ', ' . json_encode($end_date_split[2]) .')'),
    			'y' => $index,
    			'partialFill' => $presentase
    		];
    		$index++;
    	}

    	$data = [
    		[
	    		'name' => 'Project 1',
		        // pointPadding => 0,
		        // groupPadding => 0,
		        'borderColor' => 'gray',
		        'pointWidth' => 20,
		        'data' => $tmp_data,
		        'dataLabels' => [
		            'enabled' => true
		        ]
	    	]
    	];

    	return $this->render('index', [
    		'categories' => $categories,
    		'data' => $data,
    	]);
    }
}