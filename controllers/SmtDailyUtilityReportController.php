<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\WipEffDailyUtilView03;
use yii\web\JsExpression;
use app\models\WipEffView;
use app\models\WipEffNew07;
use app\models\WipEffNew03;
use app\models\WipLosstimeCategoryView;
use app\models\WipEffTbl;

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
		$loc = 'WM03';

		$loc_dropdown = \Yii::$app->params['smt_inj_loc_arr'];

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}

		if (\Yii::$app->request->get('loc') !== null) {
			$loc = \Yii::$app->request->get('loc');
		}

		$period = $year . $month;

		$tmp_working_ratio = [];
		$tmp_operation_ratio = [];

		$begin = new \DateTime(date('Y-m-d', strtotime($year . '-' . $month . '-01')));
		$end   = new \DateTime(date('Y-m-t', strtotime($year . '-' . $month . '-01')));

		for($i = $begin; $i <= $end; $i->modify('+1 day')){
			$proddate = (strtotime($i->format("Y-m-d") . " +7 hours") * 1000);
			
			foreach ($line_arr as $key => $line) {
				$tmp_y1 = null;
				$tmp_y2 = null;

				$tmp_utility_data = WipEffNew07::find()
				->where([
					'period' => $period,
					'post_date' => $i->format("Y-m-d"),
					'LINE' => $line,
					'child_analyst' => $loc
				])
				->one();

				if ($tmp_utility_data->period != null) {
					$tmp_y1 = round((float)$tmp_utility_data->working_ratio, 1);
					$tmp_y2 = round((float)$tmp_utility_data->operating_ratio, 1);
				}
				
				$tmp_working_ratio[$line][] = [
		    		'x' => $proddate,
		    		'y' => $tmp_y1,
			    	'url' => Url::to(['get-remark', 'proddate' => $i->format("Y-m-d"), 'line' => $line, 'loc' => $loc])
		    	];
		    	$tmp_operation_ratio[$line][] = [
		    		'x' => $proddate,
		    		'y' => $tmp_y2,
			    	'url' => Url::to(['get-remark', 'proddate' => $i->format("Y-m-d"), 'line' => $line, 'loc' => $loc])
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
			'period' => $period,
			'child_analyst' => $loc
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
			'period' => $period,
			'child_analyst' => $loc
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
			'Warming Up' => $wip_losstime_category->machine_warming_up,
			'Other' => $wip_losstime_category->other
		];

		arsort($losstime_category);

		foreach ($losstime_category as $key => $value) {
			$categories[] = $key;
			$tmp_losstime_category[] = [
				'name' => $key,
				'y' => round($value),
				'url' => Url::to(['get-loss-time-cat', 'period' => $period, 'child_analyst' => $loc, 'category' => $key])
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
			'loc_dropdown' => $loc_dropdown,
			'loc' => $loc,
		]);
	}

	public function actionGetLossTimeCat($period, $child_analyst, $category)
	{
		$loc_desc = \Yii::$app->params['wip_location_arr'][$child_analyst];
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Lost Time by ' . $category . '<br/>Location : ' . $loc_desc . '</h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th class="text-center">Post Date</th>
	    	<th class="">Note</th>
	    	<th class="text-center">Total Time<br/>(min)</th>
	    </tr>';

		if ($category == 'Break Time') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'break_time', 0])
		    ->all();
		} elseif ($category == 'Nozzle Maintenance') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'nozzle_maintenance', 0])
		    ->all();
		} elseif ($category == 'Change Schedule') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'change_schedule', 0])
		    ->all();
		} elseif ($category == 'Air Pressure Problem') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'air_pressure_problem', 0])
		    ->all();
		} elseif ($category == 'Power Failure') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'power_failure', 0])
		    ->all();
		} elseif ($category == 'Part Shortage') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'part_shortage', 0])
		    ->all();
		} elseif ($category == 'Set Up 1st Time Running TP') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'set_up_1st_time_running_tp', 0])
		    ->all();
		} elseif ($category == 'Part Arrangement DCN') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'part_arrangement_dcn', 0])
		    ->all();
		} elseif ($category == 'Meeting') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'meeting', 0])
		    ->all();
		} elseif ($category == 'Dandori') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'dandori', 0])
		    ->all();
		} elseif ($category == 'Program Error') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'porgram_error', 0])
		    ->all();
		} elseif ($category == 'MC Problem') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'm_c_problem', 0])
		    ->all();
		} elseif ($category == 'Feeder Problem') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'feeder_problem', 0])
		    ->all();
		} elseif ($category == 'Quality Problem') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'quality_problem', 0])
		    ->all();
		} elseif ($category == 'PCB Transfer Problem') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'pcb_transfer_problem', 0])
		    ->all();
		} elseif ($category == 'Profile Problem') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'profile_problem', 0])
		    ->all();
		} elseif ($category == 'Pick Up Error') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'pick_up_error', 0])
		    ->all();
		} elseif ($category == 'Warming Up') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'machine_warming_up', 0])
		    ->all();
		} elseif ($category == 'Other') {
			$utility_data_arr = WipEffTbl::find()
		    ->where([
		    	'period' => $period,
		    	'child_analyst' => $child_analyst
		    ])
		    ->andWhere(['>', 'other', 0])
		    ->all();
		}

	    $no = 1;
	    foreach ($utility_data_arr as $key => $utility_data) {
	    	if ($category == 'Break Time') {
	    		$tmp_note = $utility_data->note01;
	    		$total_time = $utility_data->break_time;
			} elseif ($category == 'Nozzle Maintenance') {
				$tmp_note = $utility_data->note02;
				$total_time = $utility_data->nozzle_maintenance;
			} elseif ($category == 'Change Schedule') {
				$tmp_note = $utility_data->note03;
				$total_time = $utility_data->change_schedule;
			} elseif ($category == 'Air Pressure Problem') {
				$tmp_note = $utility_data->note04;
				$total_time = $utility_data->air_pressure_problem;
			} elseif ($category == 'Power Failure') {
				$tmp_note = $utility_data->note05;
				$total_time = $utility_data->power_failure;
			} elseif ($category == 'Part Shortage') {
				$tmp_note = $utility_data->note06;
				$total_time = $utility_data->part_shortage;
			} elseif ($category == 'Set Up 1st Time Running TP') {
				$tmp_note = $utility_data->note07;
				$total_time = $utility_data->set_up_1st_time_running_tp;
			} elseif ($category == 'Part Arrangement DCN') {
				$tmp_note = $utility_data->note08;
				$total_time = $utility_data->part_arrangement_dcn;
			} elseif ($category == 'Meeting') {
				$tmp_note = $utility_data->note09;
				$total_time = $utility_data->meeting;
			} elseif ($category == 'Dandori') {
				$tmp_note = $utility_data->note10;
				$total_time = $utility_data->dandori;
			} elseif ($category == 'Program Error') {
				$tmp_note = $utility_data->note11;
				$total_time = $utility_data->porgram_error;
			} elseif ($category == 'MC Problem') {
				$tmp_note = $utility_data->note12;
				$total_time = $utility_data->m_c_problem;
			} elseif ($category == 'Feeder Problem') {
				$tmp_note = $utility_data->note13;
				$total_time = $utility_data->feeder_problem;
			} elseif ($category == 'Quality Problem') {
				$tmp_note = $utility_data->note14;
				$total_time = $utility_data->quality_problem;
			} elseif ($category == 'PCB Transfer Problem') {
				$tmp_note = $utility_data->note15;
				$total_time = $utility_data->pcb_transfer_problem;
			} elseif ($category == 'Profile Problem') {
				$tmp_note = $utility_data->note16;
				$total_time = $utility_data->profile_problem;
			} elseif ($category == 'Pick Up Error') {
				$tmp_note = $utility_data->note17;
				$total_time = $utility_data->pick_up_error;
			} elseif ($category == 'Warming Up') {
				$tmp_note = $utility_data->note18;
				$total_time = $utility_data->machine_warming_up;
			} elseif ($category == 'Other') {
				$tmp_note = $utility_data->note19;
				$total_time = $utility_data->other;
			}
	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . date('Y-m-d', strtotime($utility_data->post_date)) . '</td>
	    		<td class="">' . $tmp_note . '</td>
	    		<td class="text-center">' . number_format($total_time) . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}

	public function actionGetRemark($proddate, $line, $loc)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Line : ' . $line . ' <small>(' . $proddate . ')</small></h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th class="text-center" style="min-width: 70px;">Shift</th>
	    	<th class="text-center">Part No</th>
	    	<th style="width: 100px;">Part Description</th>
	    	<th class="text-center">Qty<br/>(A)</th>
	    	<th class="text-center">ST<br/>(B)</th>
	    	<th class="text-center">Total ST<br/>(C = A * B)</th>
	    	<th class="text-center">Lead Time<br/>(D)</th>
	    	<th class="text-center">Loss Time<br/>(Planned Loss)<br/>(E)</th>
	    	<th class="text-center">Loss Time<br/>(Out Section)<br/>(F)</th>
	    	<th class="text-center">Dandori</th>
	    	<th class="text-center">Break Down</th>
	    	<th class="text-center">Operating Loss</th>
	    	<th class="text-center">Working Time<br/>(G)</th>
	    	<th class="text-center">Operation Ratio(%)<br/>((G-E-F) / 1440)</th>
	    	<th class="text-center">Working Ratio(%)<br/>(C / (G-E-F))</th>
	    </tr>';

	    $utility_data_arr = WipEffNew03::find()
	    ->where([
	    	'post_date' => $proddate,
	    	'LINE' => $line,
	    	'child_analyst' => $loc
	    ])
	    ->orderBy('SMT_SHIFT, LINE, child_all')
	    ->all();

	    $no = 1;
	    foreach ($utility_data_arr as $key => $utility_data) {

	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . $utility_data->SMT_SHIFT . '</td>
	    		<td class="text-center">' . $utility_data->child_all . '</td>
	    		<td>' . $utility_data->child_desc_all . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->qty_all, 0) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->std_all, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->lt_std, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->lt_gross, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->planed_loss_minute, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->out_section_minute, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->dandori_minute, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->break_down_minute, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->operating_loss_minute, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->working_time, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->operating_ratio, 2) . '</td>
	    		<td class="text-center text">' . $this->thousandSeparatorFormatter($utility_data->working_ratio, 2) . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}

	function thousandSeparatorFormatter($value, $coma)
	{
		return number_format($value, $coma);
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
	    	<th class="text-center">Warming Up</th>
	    	<th class="text-center">Other</th>
	    </tr>';

	    $wip_eff_view = WipEffTbl::find()
	    ->where([
	    	'post_date' => $proddate,
	    	'LINE' => $line,
	    	'child_analyst' => 'WM03'
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
	    		$value->machine_warming_up > 0 ? 'label label-danger' : '',
	    		$value->other > 0 ? 'label label-danger' : ''
	    	];
	    	$remark .= '<tr style="font-size: 11px;">
	    		<td class="text-center" title="' . $value->child_desc_all . '">' . $value->child_all . '</td>
	    		<td class="text-center"><span title="Break Time" class="' . $class[0] . '">' . round($value->break_time, 1) . '</span></td>
	    		<td class="text-center"><span title="Nozzle Maintenance" class="' . $class[1] . '">' . round($value->nozzle_maintenance, 1) . '</span></td>
	    		<td class="text-center"><span title="Change Schedule" class="' . $class[2] . '">' . round($value->change_schedule, 1) . '</span></td>
	    		<td class="text-center"><span title="Air Pressure Problem" class="' . $class[3] . '">' . round($value->air_pressure_problem, 1) . '</span></td>
	    		<td class="text-center"><span title="Power Failure" class="' . $class[4] . '">' . round($value->power_failure, 1) . '</span></td>
	    		<td class="text-center"><span title="Part Shortage" class="' . $class[5] . '">' . round($value->part_shortage, 1) . '</span></td>
	    		<td class="text-center"><span title="Set Up 1st Time Running TP" class="' . $class[6] . '">' . round($value->set_up_1st_time_running_tp, 1) . '</span></td>
	    		<td class="text-center"><span title="Part Arrangement DCN" class="' . $class[7] . '">' . round($value->part_arrangement_dcn, 1) . '</span></td>
	    		<td class="text-center"><span title="Meeting" class="' . $class[8] . '">' . round($value->meeting, 1) . '</span></td>
	    		<td class="text-center"><span title="Dandori" class="' . $class[9] . '">' . round($value->dandori, 1) . '</span></td>
	    		<td class="text-center"><span title="Program Error" class="' . $class[10] . '">' . round($value->porgram_error, 1) . '</span></td>
	    		<td class="text-center"><span title="MC Problem" class="' . $class[11] . '">' . round($value->m_c_problem, 1) . '</span></td>
	    		<td class="text-center"><span title="Feeder Problem" class="' . $class[12] . '">' . round($value->feeder_problem, 1) . '</span></td>
	    		<td class="text-center"><span title="Quality Problem" class="' . $class[13] . '">' . round($value->quality_problem, 1) . '</span></td>
	    		<td class="text-center"><span title="PCB Transfer Problem" class="' . $class[14] . '">' . round($value->pcb_transfer_problem, 1) . '</span></td>
	    		<td class="text-center"><span title="Profile Problem" class="' . $class[15] . '">' . round($value->profile_problem, 1) . '</span></td>
	    		<td class="text-center"><span title="Pick Up Error" class="' . $class[16] . '">' . round($value->pick_up_error, 1) . '</span></td>
	    		<td class="text-center"><span title="Warming Up" class="' . $class[17] . '">' . round($value->machine_warming_up, 1) . '</span></td>
	    		<td class="text-center"><span title="Other" class="' . $class[18] . '">' . round($value->other, 1) . '</span></td>
	    	</tr>';
	    }

	    return $remark;
	}
}