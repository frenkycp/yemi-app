<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\PickingLocation;
use app\models\VisualPickingView02;
use app\models\VisualPickingView;
use yii\helpers\ArrayHelper;

class PartsPickingStatusController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$data = [];
    	$model = new PickingLocation();
    	$model->location = 'WF01';
    	$model->load($_POST);
    	$dropdown_loc = ArrayHelper::map(VisualPickingView02::find()->select('analyst, analyst_desc')->groupBy('analyst, analyst_desc')->orderBy('analyst_desc ASC')->all(), 'analyst', 'analyst_desc');

    	$visual_picking_arr = VisualPickingView02::find()
    	->where([
    		'year' => date('Y'),
    		'analyst' => $model->location
    	])
    	->orderBy('week ASC, req_date')
    	->all();

    	$week_period = $this->getWeekPeriod($model->location);
    	$today = new \DateTime(date('Y-m-d'));
		$this_week = $today->format("W");
		if (!in_array($this_week, $week_period)) {
			$this_week = end($week_period);
		}

    	foreach ($week_period as $week_no) {
    		$tmp_category = [];
    		$tmp_data_open = [];
    		$tmp_data_close = [];
    		foreach ($visual_picking_arr as $visual_picking) {
    			if ($week_no == $visual_picking->week) {
    				$tmp_category[] = date('Y-m-d', strtotime($visual_picking->req_date));

    				$open_qty = $visual_picking->slip_open;
    				$close_qty = $visual_picking->slip_close;
    				$total_qty = $visual_picking->slip_count;

    				$open_percentage = 0;
    				$close_percentage = 0;
    				if ($total_qty > 0) {
    					$open_percentage = round((($open_qty / $total_qty) * 100), 2);
    					$close_percentage = round((($close_qty / $total_qty) * 100), 2);
    				}

    				$tmp_data_open[] = [
    					'y' => $open_percentage == 0 ? null : $open_percentage,
    					'remark' => $this->getRemark($visual_picking->req_date, $visual_picking->analyst, 1)
    				];
    				$tmp_data_close[] = [
    					'y' => $close_percentage == 0 ? null : $close_percentage,
    					'remark' => $this->getRemark($visual_picking->req_date, $visual_picking->analyst, 0)
    				];
    			}
    		}
    		$data[$week_no][] = [
    			'category' => $tmp_category,
    			'data' => [
    				[
    					'name' => 'OUTSTANDING',
    					'data' => $tmp_data_open,
    					'color' => 'rgba(200, 200, 200, 0.4)',
    					'showInLegend' => false,
    					'dataLabels' => [
    						'enabled' => false
    					]
    				],
    				[
    					'name' => 'DEPARTURE',
    					'data' => $tmp_data_close,
    					'color' => 'rgba(0, 200, 0, 0.4)',
    					'showInLegend' => false,
    				],
    			]
    		];
    	}

    	return $this->render('index', [
    		'model' => $model,
    		'dropdown_loc' => $dropdown_loc,
    		'data' => $data,
    		'this_week' => $this_week
    	]);
    }

    public function getRemark($req_date, $analyst, $slip_open)
    {
    	$data_arr = VisualPickingView::find()
    	->where([
    		'req_date' => $req_date,
    		'analyst' => $analyst,
    		'slip_open' => $slip_open
    	])
    	->orderBy('set_list_no ASC')
    	->all();

    	$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th class="text-center">Setlist No</th>
			<th class="text-center">Parent</th>
			<th>Parent Description</th>
			<th class="text-center" style="width: 100px;">Req Date</th>
			<th class="text-center">Plan Qty</th>
			<th class="text-center">Part Count</th>
			<th class="text-center">Man Power</th>
            <th class="text-center" style="width:90px;">Start Date</th>
            <th class="text-center" style="width:90px;">Completed Date</th>
			<th class="text-center">Confirm</th>
		</tr>'
		;

		foreach ($data_arr as $value) {
			$data .= '
				<tr>
					<td class="text-center">' . $value['set_list_no'] . '</td>
					<td class="text-center">' . $value['parent'] . '</td>
					<td>' . $value['parent_desc'] . '</td>
					<td class="text-center">' . date('Y-m-d', strtotime($value['req_date'])) . '</td>
					<td class="text-center">' . $value['plan_qty'] . '</td>
					<td class="text-center">' . $value['part_count'] . '</td>
					<td class="text-center">' . $value['man_power'] . '</td>
                    <td class="text-center">' . date('Y-m-d H:i:s', strtotime($value['start_date'])) . '</td>
                    <td class="text-center">' . date('Y-m-d H:i:s', strtotime($value['completed_date'])) . '</td>
					<td class="text-center">' . $value['stage_desc'] . '</td>
				</tr>
				';
		}

		$data .= '</table>';
		return $data;
    }

    public function getWeekPeriod($analyst)
    {
    	$return_arr = [];
    	$data_arr = VisualPickingView02::find()
    	->select('week')
    	->where([
    		'year' => date('Y'),
    		'analyst' => $analyst
    	])
    	->groupBy('week')
    	->all();

    	$selisih = count($data_arr) - 10;

    	$i = 1;
    	foreach ($data_arr as $value) {
    		if ($i > $selisih) {
    			$return_arr[] = $value->week;
    		}
    		$i++;
    	}

    	return $return_arr;
    }
}