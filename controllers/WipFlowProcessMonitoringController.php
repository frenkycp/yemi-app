<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\WipFlowView02;
use yii\web\JsExpression;
use app\models\FlowProcessFilterModel;
use yii\helpers\Url;

class WipFlowProcessMonitoringController extends Controller
{

	/*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/
    
    public function actionIndex()
    {
		$model = new FlowProcessFilterModel();
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

		//$group_model = $gmc = '-';
		
		if ($model->load($_GET)) {
			if($model->model != null){
				$group_model = $model->model;
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
				->where([
					'model_group' => $model->model
				])
				->groupBy('period, child_analyst, child_analyst_desc')
				->all();
			}
			if($model->gmc != null){
				$gmc = $model->gmc;
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
				->where([
					'parent' => $model->gmc
				])
				->groupBy('period, child_analyst, child_analyst_desc')
				->all();
			}
		}

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
    			'url' => Url::to(['wip-flow-data-view/index', 'start_date' => $start_date, 'end_date' => $end_date, 'location' => $value->child_analyst_desc, 'period' => $value->period, 'group_model' => $group_model, 'gmc' => $gmc]),
    			'partialFill' => $presentase,
    			'color' => 'white'
    		];
    		$index++;
    	}

    	$data = [
    		[
	    		'name' => 'WIP',
		        // pointPadding => 0,
		        // groupPadding => 0,
		        'borderColor' => 'rgba(72,61,139,0.6)',
		        'pointWidth' => 20,
		        'partialFill' => [
		        	'fill' => 'rgba(72,61,139,0.6)'
		        ],
		        'data' => $tmp_data,
		        'dataLabels' => [
					'enabled' => true,
					'style' => [
						'textOutline' => '0px',
						'fontWeight' => '0'
					],
					'formatter' => new JsExpression('function(){ return Math.round(this.point.partialFill * 100) + \'%\'; }'),
		        ]
	    	]
    	];

    	return $this->render('index', [
    		'categories' => $categories,
			'data' => $data,
			'model' => $model
    	]);
    }

    public function actionGetRemark($start_date, $end_date, $location, $period, $group_model, $gmc)
    {
    	$get_data_arr = WipFlowView02::find()
    	->where([
    		'period' => $period,
    		'child_analyst_desc' => $location
    	])
    	->orderBy('due_date')
    	->asArray()
    	->all();

    	if($group_model != '-'){
    		$get_data_arr = WipFlowView02::find()
	    	->where([
	    		'period' => $period,
	    		'child_analyst_desc' => $location,
	    		'model_group' => $group_model
	    	])
	    	->orderBy('due_date')
	    	->asArray()
	    	->all();
    	}

    	if($gmc != '-'){
				$get_data_arr = WipFlowView02::find()
		    	->where([
		    		'period' => $period,
		    		'child_analyst_desc' => $location,
		    		'parent' => $gmc
		    	])
		    	->orderBy('due_date')
		    	->asArray()
				->all();
			}

    	$data = "<h4>$location<small> ($start_date to $end_date)</small></h4>";
		$data .= '<table class="table table-bordered table-hover">';
		$data .= 
		'<thead style="font-size: 12px;"><tr class="info">
            <th class="text-center">Location</th>
            <th class="text-center">GMC</th>
            <th>Description</th>
            <th class="text-center">Due Date</th>
            <th class="text-center">Plan Qty</th>
            <th class="text-center">Actual Qty</th>
		</tr></thead>';
		$data .= '<tbody style="font-size: 12px;">';

		foreach ($get_data_arr as $key => $value) {
			$row_class = '';
			if ($value['balance_qty'] > 0) {
				$row_class = 'danger';
			}
			$due_date = $value['due_date'] == null ? '-' : date('Y-m-d', strtotime($value['due_date']));
			$data .= '
				<tr class="' . $row_class . '">
					<td class="text-center">' . $value['child_analyst_desc'] . '</td>
					<td class="text-center">' . $value['parent'] . '</td>
					<td>' . $value['parent_desc'] . '</td>
					<td class="text-center">' . $due_date . '</td>
                    <td class="text-center">' . $value['plan_qty'] . '</td>
                    <td class="text-center">' . $value['act_qty'] . '</td>
				</tr>
			';
		}

		$data .= '</tbody>';
		$data .= '</table>';

		return $data;
    }
}