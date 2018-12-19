<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\WipEffDailyUtilView03;
use yii\web\JsExpression;
use app\models\WipEffView;
use app\models\WipLosstimeCategoryView;

class SmtDailyUtilityReportController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$year = date('Y');
		$month = date('m');
		$line_arr = ['01', '02'];

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}

		$period = $year . $month;

		$utility_data_arr = WipEffDailyUtilView03::find()
		->where([
			'period' => $period
		])
		->asArray()
		->all();

		$tmp_working_ratio = [];
		$tmp_operation_ratio = [];

		$begin = new \DateTime(date('Y-m-01'));
		$end   = new \DateTime(date('Y-m-t'));

		for($i = $begin; $i <= $end; $i->modify('+1 day')){
			$proddate = (strtotime($i->format("Y-m-d") . " +7 hours") * 1000);
			
			foreach ($line_arr as $key => $line) {
				$tmp_y1 = null;
				$tmp_y2 = null;
				foreach ($utility_data_arr as $key => $utility_data) {
			   		if ($utility_data['post_date'] == $i->format("Y-m-d") && $utility_data['LINE'] == $line) {
			   			$tmp_y1 = round((float)$utility_data['Working_Ratio'], 1);
			   			$tmp_y2 = round((float)$utility_data['Operation_Ratio'], 1);
			   		}
				}
				$tmp_working_ratio[$line][] = [
		    		'x' => $proddate,
		    		'y' => $tmp_y1,
			    	'url' => Url::to(['get-remark', 'proddate' => $i->format("Y-m-d"), 'line' => $line])
		    	];
		    	$tmp_operation_ratio[$line][] = [
		    		'x' => $proddate,
		    		'y' => $tmp_y2,
			    	'url' => Url::to(['get-remark', 'proddate' => $i->format("Y-m-d"), 'line' => $line])
		    	];
			}
		   	
			
		}
		
		

		$data = [
			'working_ratio' => [
				[
			    	'name' => 'Line 1',
			    	'data' => $tmp_working_ratio['01'],
			    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
			    ],
			    [
			    	'name' => 'Line 2',
			    	'data' => $tmp_working_ratio['02'],
			    	'color' => new JsExpression('Highcharts.getOptions().colors[7]'),
			    ],
			],
			'operation_ratio' => [
				[
			    	'name' => 'Line 1',
			    	'data' => $tmp_operation_ratio['01'],
			    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
			    ],
			    [
			    	'name' => 'Line 2',
			    	'data' => $tmp_operation_ratio['02'],
			    	'color' => new JsExpression('Highcharts.getOptions().colors[7]'),
			    ],
			],
		];

		$wip_eff_view = WipEffView::find()
		->where([
			'period' => $period
		])
		->orderBy('post_date, line')
		->all();

		$tmp_data = [];
		foreach ($wip_eff_view as $key => $value) {
			if (!isset($tmp_data[$value->post_date][$value->LINE]['losstime'])) {
				$tmp_data[$value->post_date][$value->LINE]['losstime'] = 0;
			}
			$tmp_data[$value->post_date][$value->LINE]['losstime'] += $value->lt_loss;
		}

		foreach ($tmp_data as $key => $value) {
			$post_date = (strtotime($key . " +7 hours") * 1000);
			$tmp_line1[] = [
				'x' => $post_date,
				'y' => round($value['01']['losstime']),
				'url' => Url::to(['get-loss-time-line', 'proddate' => $key, 'line' => '01'])
			];
			$tmp_line2[] = [
				'x' => $post_date,
				'y' => round($value['02']['losstime']),
				'url' => Url::to(['get-loss-time-line', 'proddate' => $key, 'line' => '02'])
			];
		}

		$data2 = [
			[
				'name' => 'Line 1',
				'data' => $tmp_line1,
				'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
			],
			[
				'name' => 'Line 2',
				'data' => $tmp_line2,
				'color' => new JsExpression('Highcharts.getOptions().colors[7]'),
			],
		];

		$wip_losstime_category = WipLosstimeCategoryView::find()
		->where([
			'period' => $period
		])
		->one();

		$losstime_category = [
			'Break Time' => $wip_losstime_category->break_time,
			'Nozzle Maintenance' => $wip_losstime_category->nozzle_maintenance,
			'Change Schedule' => $wip_losstime_category->change_schedule,
			'Air Pressure Problem' => $wip_losstime_category->air_pressure_problem,
			'Power Failure' => $wip_losstime_category->power_failure,
			'Part Shortage' => $wip_losstime_category->part_shortage,
			'Set Up 1st Time Running TP' => $wip_losstime_category->set_up_1st_time_running_tp,
			'Part Arrangement DCN' => $wip_losstime_category->part_arrangement_dcn,
			'Meeting' => $wip_losstime_category->meeting,
			'Dandori' => $wip_losstime_category->dandori,
			'Program Error' => $wip_losstime_category->porgram_error,
			'MC Problem' => $wip_losstime_category->m_c_problem,
			'Feeder Problem' => $wip_losstime_category->feeder_problem,
			'Quality Problem' => $wip_losstime_category->quality_problem,
			'PCB Transfer Problem' => $wip_losstime_category->pcb_transfer_problem,
			'Profile Problem' => $wip_losstime_category->profile_problem,
			'Pick Up Error' => $wip_losstime_category->pick_up_error,
			'Other' => $wip_losstime_category->other
		];

		arsort($losstime_category);

		foreach ($losstime_category as $key => $value) {
			$categories[] = $key;
			$tmp_losstime_category[] = [
				'name' => $key,
				'y' => round($value)
			];
		}

		$data_losstime_category = [
			[
				'name' => 'Monthly Loss Time by Category',
				'data' => $tmp_losstime_category
			],
		];

		return $this->render('index', [
			'data' => $data,
			'tmp_data' => $tmp_data,
			'data2' => $data2,
			'year' => $year,
			'month' => $month,
			'data_losstime_category' => $data_losstime_category,
			'categories' => $categories,
		]);
	}

	public function actionGetRemark($proddate, $line)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Line : ' . $line . ' <small>(' . $proddate . ')</small></h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 11px;">
	    	<th class="text-center" style="min-width: 70px;">Shift</th>
	    	<th class="text-center">Part No</th>
	    	<th>Part Description</th>
	    	<th class="text-center">Qty</th>
	    	<th class="text-center">ST</th>
	    	<th class="text-center">LT (Std)</th>
	    	<th class="text-center">LT (Gross)</th>
	    	<th class="text-center">LT (Nett)</th>
	    	<th class="text-center">Loss Time</th>
	    	<th class="text-center">Gross Util.<br/>(%)</th>
	    	<th class="text-center">Nett Util.<br/>(%)</th>
	    </tr>';

	    $utility_data_arr = WipEffView::find()
	    ->where([
	    	'CONVERT(date, post_date)' => $proddate,
	    	'LINE' => $line
	    ])
	    ->orderBy('SMT_SHIFT, LINE, child_01')
	    ->all();

	    $no = 1;
	    foreach ($utility_data_arr as $key => $utility_data) {
	    	$remark .= '<tr style="font-size: 10px;">
	    		<td class="text-center">' . $utility_data->SMT_SHIFT . '</td>
	    		<td class="text-center">' . $utility_data->child_01 . '</td>
	    		<td>' . $utility_data->child_desc_01 . '</td>
	    		<td class="text-center">' . $utility_data->qty_all . '</td>
	    		<td class="text-center">' . $utility_data->std_all . '</td>
	    		<td class="text-center">' . $utility_data->lt_std . '</td>
	    		<td class="text-center">' . $utility_data->lt_gross . '</td>
	    		<td class="text-center">' . $utility_data->lt_nett . '</td>
	    		<td class="text-center">' . $utility_data->lt_loss . '</td>
	    		<td class="text-center"><span class="text-green"><b>' . round($utility_data->efisiensi_gross, 1) . '</b></td>
	    		<td class="text-center"><span class="text-green"><b>' . round($utility_data->efisiensi, 1) . '</b></td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}

	public function actionGetLossTimeLine($proddate, $line)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Line : ' . $line . ' <small>(' . $proddate . ')<small></h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 8px;">
	    	<th class="text-center">GMC</th>
	    	<th class="text-center">Break<br/>Time</th>
	    	<th class="text-center">Nozzle<br/>Mnt.</th>
	    	<th class="text-center">Change<br/>Sch.</th>
	    	<th class="text-center">Air<br/>Pressure</th>
	    	<th class="text-center">Power<br/>Failure</th>
	    	<th class="text-center">Parts<br/>Shortage</th>
	    	<th class="text-center">Set Up<br/>1st TP</th>
	    	<th class="text-center">Part<br/>DCN</th>
	    	<th class="text-center">Meeting</th>
	    	<th class="text-center">Dandori</th>
	    	<th class="text-center">Program<br/>Error</th>
	    	<th class="text-center">MC<br/>Problem</th>
	    	<th class="text-center">Feeder<br/>Problem</th>
	    	<th class="text-center">Quality<br/>Problem</th>
	    	<th class="text-center">PCB Trf.<br/>Problem</th>
	    	<th class="text-center">Profile<br/>Problem</th>
	    	<th class="text-center">Pick Up<br/>Error</th>
	    	<th class="text-center">Other</th>
	    </tr>';

	    $wip_eff_view = WipEffView::find()
	    ->where([
	    	'post_date' => $proddate,
	    	'LINE' => $line
	    ])
	    ->all();

	    foreach ($wip_eff_view as $key => $value) {
	    	$class = [
	    		$value->break_time > 0 ? 'label label-danger' : '',
	    		$value->nozzle_maintenance > 0 ? 'label label-danger' : '',
	    		$value->change_schedule > 0 ? 'label label-danger' : '',
	    		$value->air_pressure_problem > 0 ? 'label label-danger' : '',
	    		$value->power_failure > 0 ? 'label label-danger' : '',
	    		$value->part_shortage > 0 ? 'label label-danger' : '',
	    		$value->set_up_1st_time_running_tp > 0 ? 'label label-danger' : '',
	    		$value->part_arrangement_dcn > 0 ? 'label label-danger' : '',
	    		$value->meeting > 0 ? 'label label-danger' : '',
	    		$value->dandori > 0 ? 'label label-danger' : '',
	    		$value->porgram_error > 0 ? 'label label-danger' : '',
	    		$value->m_c_problem > 0 ? 'label label-danger' : '',
	    		$value->feeder_problem > 0 ? 'label label-danger' : '',
	    		$value->quality_problem > 0 ? 'label label-danger' : '',
	    		$value->pcb_transfer_problem > 0 ? 'label label-danger' : '',
	    		$value->profile_problem > 0 ? 'label label-danger' : '',
	    		$value->pick_up_error > 0 ? 'label label-danger' : '',
	    		$value->other > 0 ? 'label label-danger' : ''
	    	];
	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center" title="' . $value->child_desc_01 . '">' . $value->child_01 . '</td>
	    		<td class="text-center"><span title="Break Time" class="' . $class[0] . '">' . round($value->break_time) . '</span></td>
	    		<td class="text-center"><span title="Nozzle Maintenance" class="' . $class[1] . '">' . round($value->nozzle_maintenance) . '</span></td>
	    		<td class="text-center"><span title="Change Schedule" class="' . $class[2] . '">' . round($value->change_schedule) . '</span></td>
	    		<td class="text-center"><span title="Air Pressure Problem" class="' . $class[3] . '">' . round($value->air_pressure_problem) . '</span></td>
	    		<td class="text-center"><span title="Power Failure" class="' . $class[4] . '">' . round($value->power_failure) . '</span></td>
	    		<td class="text-center"><span title="Part Shortage" class="' . $class[5] . '">' . round($value->part_shortage) . '</span></td>
	    		<td class="text-center"><span title="Set Up 1st Time Running TP" class="' . $class[6] . '">' . round($value->set_up_1st_time_running_tp) . '</span></td>
	    		<td class="text-center"><span title="Part Arrangement DCN" class="' . $class[7] . '">' . round($value->part_arrangement_dcn) . '</span></td>
	    		<td class="text-center"><span title="Meeting" class="' . $class[8] . '">' . round($value->meeting) . '</span></td>
	    		<td class="text-center"><span title="Dandori" class="' . $class[9] . '">' . round($value->dandori) . '</span></td>
	    		<td class="text-center"><span title="Program Error" class="' . $class[10] . '">' . round($value->porgram_error) . '</span></td>
	    		<td class="text-center"><span title="MC Problem" class="' . $class[11] . '">' . round($value->m_c_problem) . '</span></td>
	    		<td class="text-center"><span title="Feeder Problem" class="' . $class[12] . '">' . round($value->feeder_problem) . '</span></td>
	    		<td class="text-center"><span title="Quality Problem" class="' . $class[13] . '">' . round($value->quality_problem) . '</span></td>
	    		<td class="text-center"><span title="PCB Transfer Problem" class="' . $class[14] . '">' . round($value->pcb_transfer_problem) . '</span></td>
	    		<td class="text-center"><span title="Profile Problem" class="' . $class[15] . '">' . round($value->profile_problem) . '</span></td>
	    		<td class="text-center"><span title="Pick Up Error" class="' . $class[16] . '">' . round($value->pick_up_error) . '</span></td>
	    		<td class="text-center"><span title="Other" class="' . $class[17] . '">' . round($value->other) . '</span></td>
	    	</tr>';
	    }

	    return $remark;
	}
}