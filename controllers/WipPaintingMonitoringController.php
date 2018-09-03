<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\WipFilterModel;
use app\models\WipPlanActualReport;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

class WipPaintingMonitoringController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$year_arr = [];
		$month_arr = [];

        $year_now = date('Y');
        $star_year = 2017;
        for ($year = $star_year; $year <= ($year_now + 1); $year++) {
            $year_arr[$year] = $year;
        }

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

    	$period = date('Ym');
    	$model = new WipFilterModel();
    	$model->month = date('m');
		$model->year = date('Y');
    	if ($model->load($_GET)) {
    		$period = $model->year . $model->month;
    	}
    	$wip_painting_data_arr = WipPlanActualReport::find()
    	->select([
    		'week',
    		'due_date',
    		'total_plan' => 'SUM(summary_qty)',
    		'total_order' => 'SUM(CASE WHEN stage=\'00-ORDER\' OR stage=\'01-CREATED\' THEN summary_qty ELSE 0 END)',
    		//'total_created' => 'SUM(CASE WHEN stage=\'01-CREATED\' THEN summary_qty ELSE 0 END)',
    		'total_started' => 'SUM(CASE WHEN stage=\'02-STARTED\' THEN summary_qty ELSE 0 END)',
    		'total_completed' => 'SUM(CASE WHEN stage=\'03-COMPLETED\' THEN summary_qty ELSE 0 END)',
    		'total_handover' => 'SUM(CASE WHEN stage=\'04-HAND OVER\' THEN summary_qty ELSE 0 END)'
    	])
    	->where([
    		'period' => $period
    	])
    	->groupBy('week, due_date')
    	->orderBy('week, due_date')
    	->all();

    	if ($model->loc != null) {
    		$wip_painting_data_arr = WipPlanActualReport::find()
	    	->select([
	    		'week',
	    		'due_date',
	    		'total_plan' => 'SUM(summary_qty)',
	    		'total_order' => 'SUM(CASE WHEN stage=\'00-ORDER\' OR stage=\'01-CREATED\' THEN summary_qty ELSE 0 END)',
	    		//'total_created' => 'SUM(CASE WHEN stage=\'01-CREATED\' THEN summary_qty ELSE 0 END)',
	    		'total_started' => 'SUM(CASE WHEN stage=\'02-STARTED\' THEN summary_qty ELSE 0 END)',
	    		'total_completed' => 'SUM(CASE WHEN stage=\'03-COMPLETED\' THEN summary_qty ELSE 0 END)',
	    		'total_handover' => 'SUM(CASE WHEN stage=\'04-HAND OVER\' THEN summary_qty ELSE 0 END)'
	    	])
	    	->where([
	    		'period' => $period,
	    		'child_analyst_desc' => $model->loc
	    	])
	    	->groupBy('week, due_date')
	    	->orderBy('week, due_date')
	    	->all();
    	}

    	//$data = [];
    	$week_arr = [];
    	$tmp_data = [];
    	foreach ($wip_painting_data_arr as $wip_painting_data) {
    		$tmp_data[$wip_painting_data->week]['category'][] = date('Y-m-d', strtotime($wip_painting_data->due_date));

    		$order_percentage = $wip_painting_data->total_plan == 0 ? 0 : round(($wip_painting_data->total_order / $wip_painting_data->total_plan) * 100);
    		//$created_percentage = $wip_painting_data->total_plan == 0 ? 0 : round(($wip_painting_data->total_created / $wip_painting_data->total_plan) * 100);
    		$started_percentage = $wip_painting_data->total_plan == 0 ? 0 : round(($wip_painting_data->total_started / $wip_painting_data->total_plan) * 100);
    		$completed_percentage = $wip_painting_data->total_plan == 0 ? 0 : round(($wip_painting_data->total_completed / $wip_painting_data->total_plan) * 100);
    		$handover_percentage = $wip_painting_data->total_plan == 0 ? 0 : round(($wip_painting_data->total_handover / $wip_painting_data->total_plan) * 100);

    		$tmp_data[$wip_painting_data->week]['order_percentage'][] = [
    			'y' => $order_percentage == 0 ? null : $order_percentage,
				'remark' => $this->getRemarks($wip_painting_data->due_date, $model->loc, '00-ORDER'),
                'qty' => $wip_painting_data->total_order
				//'color' => 'rgba(240, 240, 240, 0.7)',
    		];
    		/*$tmp_data[$wip_painting_data->week]['created_percentage'][] = [
    			'y' => $created_percentage == 0 ? null : $created_percentage,
    			'remark' => $this->getRemarks($wip_painting_data->due_date, $model->loc, '01-CREATED')
    		];*/
    		$tmp_data[$wip_painting_data->week]['started_percentage'][] = [
    			'y' => $started_percentage == 0 ? null : $started_percentage,
				'remark' => $this->getRemarks($wip_painting_data->due_date, $model->loc, '02-STARTED'),
                'qty' => $wip_painting_data->total_started
				//'color' => 'rgba(240, 240, 0, 0.7)',
    		];
    		$tmp_data[$wip_painting_data->week]['completed_percentage'][] = [
    			'y' => $completed_percentage == 0 ? null : $completed_percentage,
				'remark' => $this->getRemarks($wip_painting_data->due_date, $model->loc, '03-COMPLETED'),
                'qty' => $wip_painting_data->total_completed
				//'color' => 'rgba(0, 150, 255, 0.7)',
    		];
    		$tmp_data[$wip_painting_data->week]['handover_percentage'][] = [
    			'y' => $handover_percentage <= 0 ? null : $handover_percentage,
				'remark' => $this->getRemarks($wip_painting_data->due_date, $model->loc, '04-HAND OVER'),
                'qty' => $wip_painting_data->total_handover
				//'color' => 'rgba(0, 240, 0, 0.7)',
    		];

    		$week_arr[] = $wip_painting_data->week;
    	}

    	$today = new \DateTime(date('Y-m-d'));
		$this_week = $today->format("W");
		if (!in_array($this_week, $week_arr)) {
			$this_week = end($week_arr);
		}

		$data = [];

		foreach ($tmp_data as $week_no => $value) {
			$data[$week_no] = [
				'category' => $value['category'],
				'data' => [
					[
						'name' => 'ORDERED （受注）',
						'data' => $value['order_percentage'],
						'color' => 'rgba(255, 255, 255, 0.5)',
						//'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
					],
					/*[
						'name' => 'CREATED',
						'data' => $value['created_percentage'],
						'color' => new JsExpression('Highcharts.getOptions().colors[6]'),
					],*/
					[
						'name' => 'STARTED （加工中）',
						'data' => $value['started_percentage'],
						'color' => 'rgba(240, 240, 0, 0.5)',
						//'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
					],
					[
						'name' => 'COMPLETED （加工上がり）',
						'data' => $value['completed_percentage'],
						'color' => 'rgba(0, 150, 255, 0.5)',
						//'color' => new JsExpression('Highcharts.getOptions().colors[4]'),
					],
					[
						'name' => 'HANDOVER （後工程に引渡し）',
						'data' => $value['handover_percentage'],
						'color' => 'rgba(0, 240, 0, 0.5)',
						//'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
					]
				]
			];
		}

		$dropdown_loc = ArrayHelper::map(WipPlanActualReport::find()->select('child_analyst_desc, child_analyst_desc')->groupBy('child_analyst_desc')->orderBy('child_analyst_desc ASC')->all(), 'child_analyst_desc', 'child_analyst_desc');

    	return $this->render('index', [
    		'data' => $data,
    		'this_week' => $this_week,
    		'model' => $model,
    		'dropdown_loc' => $dropdown_loc,
    		'year_arr' => $year_arr,
    		'month_arr' => $month_arr
    	]);
    }

    public function getRemarks($due_date, $loc, $stage)
    {
        switch ($stage) {
            case '00-ORDER':
                $status = 'ORDERED';
                break;

            /*case '01-CREATED':
                $status = 'ORDERED';
                break;*/

            case '02-STARTED':
                $status = 'STARTED';
                break;

            case '03-COMPLETED':
                $status = 'COMPLETED';
                break;

            case '04-HAND OVER':
                $status = 'HANDOVER';
                break;
            
            default:
                // code...
                break;
        };

        if ($stage == '00-ORDER') {
            $stage = ['00-ORDER', '01-CREATED'];
        }

    	$wip_painting_data_arr = WipPlanActualReport::find()
    	->where([
    		'due_date' => $due_date,
    		'stage' => $stage,
            //'urut' => '02'
    	])
    	->orderBy('child_analyst_desc, model_group, parent, child')
    	->all();

    	if ($loc != null) {
    		$wip_painting_data_arr = WipPlanActualReport::find()
	    	->where([
	    		'due_date' => $due_date,
	    		'stage' => $stage,
	    		'child_analyst_desc' => $loc
	    	])
	    	->orderBy('child_analyst_desc, model_group, parent, child')
	    	->all();
    	}

        $data = '<h4>' . $status . '</h4>';
    	$data .= '<table class="table table-bordered table-hover">';
    	$data .= 
		'<thead style="font-size: 10px;"><tr class="info">
			<th class="text-center">Location</th>
            <th class="text-center">Slip No.</th>
            <th class="text-center">Line</th>
			<th>Model</th>
			<th>Child Description</th>
			<th class="text-center">Qty</th>
            <th class="text-center" style="min-width: 80px;">FA Start</th>
            <th class="text-center" style="min-width: 100px;">Start Plan</th>
            <th class="text-center" style="min-width: 100px;">End Plan</th>
			<th class="text-center" style="min-width: 100px;">Start Actual</th>
			<th class="text-center" style="min-width: 100px;">End Actual</th>
		</tr></thead>';
        $data .= '<tbody style="font-size: 10px;">';
		foreach ($wip_painting_data_arr as $value) {
            $start_plan = $value['start_date'] == null ? '-' : date('Y-m-d', strtotime($value['start_date']));
            $end_plan = $value['due_date'] == null ? '-' : date('Y-m-d', strtotime($value['due_date']));
			$start_actual = $value['start_job'] == null ? '-' : $value['start_job'];
			$end_actual = $value['end_job'] == null ? '-' : $value['end_job'];
            $fa_start = $value['source_date'] == null ? '-' : date('Y-m-d', strtotime($value['source_date']));
			$data .= '
				<tr>
					<td class="text-center">' . $value['child_analyst_desc'] . '</td>
                    <td class="text-center">' . $value['slip_id'] . '</td>
                    <td class="text-center">' . $value['period_line'] . '</td>
					<td>' . $value['model_group'] . '</td>
					<td>' . $value['child_desc'] . '</td>
					<td class="text-center">' . $value['summary_qty'] . '</td>
                    <td class="text-center">' . $fa_start . '</td>
                    <td class="text-center">' . $start_plan . '</td>
                    <td class="text-center">' . $end_plan . '</td>
					<td class="text-center text-green">' . $start_actual . '</td>
					<td class="text-center text-green">' . $end_actual . '</td>
				</tr>
			';
		}
        $data .= '</tbody>';

		$data .= '</table>';
		return $data;
    }
}