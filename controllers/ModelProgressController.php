<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\WipPlanActualReport;
use app\models\WipLocation;

class ModelProgressController extends Controller
{
	public function actionIndex()
	{
		$loc_arr = [];
		$model = new \yii\base\DynamicModel([
	        'gmc', 'year', 'month', 'location'
	    ]);
	    $model->addRule(['gmc','year', 'month', 'location'], 'required');

	    $model->month = date('m');
		$model->year = date('Y');

		$data = [];
	    if ($model->load($_GET)) {
	    	$period = $model->year . $model->month;
	    	$loc_arr = $model->location;
	    	$tmp_wip = WipPlanActualReport::find()
    		->select([
    			'child_analyst',
    			'child_analyst_desc',
    			'start_date',
    			'total_plan' => 'SUM(summary_qty)',
    			'total_actual' => 'SUM(CASE WHEN stage in (\'03-COMPLETED\', \'04-HAND OVER\') THEN summary_qty ELSE 0 END)'
    		])
    		->where([
    			'period' => $period,
    			'parent' => $model->gmc,
    		])
    		->groupBy('child_analyst, child_analyst_desc, start_date')
    		->orderBy('child_analyst, child_analyst_desc, start_date')
    		->asArray()
    		->all();
	    	foreach ($loc_arr as $key => $loc) {
	    		$tmp_data_open = $tmp_data_close = [];
	    		$location = WipLocation::find()
	    		->where([
	    			'child_analyst' => $loc
	    		])
	    		->one();
	    		foreach ($tmp_wip as $key => $value) {
	    			
	    			
	    			$plan_qty = $act_qty = 0;
	    			if ($value['child_analyst'] == $loc) {
	    				$due_date = (strtotime($value['start_date'] . " +7 hours") * 1000);
	    				$plan_qty = $value['total_plan'];
	    				$act_qty = $value['total_actual'];
	    				$heading = $value['child_analyst_desc'];
	    				$outstanding_qty = $plan_qty - $act_qty;
		    			$tmp_data_open[] = [
		    				'x' => $due_date,
							'y' => $outstanding_qty == 0 ? null : (float)$outstanding_qty,
		    			];
		    			$tmp_data_close[] = [
		    				'x' => $due_date,
							'y' => $act_qty == 0 ? null : (float)$act_qty,
		    			];
	    			}
	    			
	    			
	    		}
	    		$data[$loc] = [
	    			'title' => $location->child_analyst_desc,
	    			'series' => [
	    				[
	    					'name' => 'Open',
	    					'data' => $tmp_data_open,
	    					'color' => 'rgba(255, 0, 0, 0.8)'
	    				],
	    				[
	    					'name' => 'Close',
	    					'data' => $tmp_data_close,
	    					'color' => 'rgba(0, 255, 0, 0.8)'
	    				],
	    			],
	    		];
	    	}
	    }

		return $this->render('index', [
			'model' => $model,
			'data' => $data,
			'loc_arr' => $loc_arr
		]);
	}
}