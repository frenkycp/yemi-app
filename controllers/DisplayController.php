<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

//production-monthly-inspection
use app\models\InspectionReportView;
use app\models\SernoInput;
use app\models\PlanReceivingPeriod;

//parts-picking-status
use app\models\PickingLocation;
use app\models\VisualPickingView02;
use app\models\VisualPickingView;

//smt-dandori
use app\models\WipEff03Dandori05;

class DisplayController extends Controller
{
	public function actionProductionMonthlyInspection()
	{
		$this->layout = 'clean';
		$categories = [];

    	$year_arr = [];
        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $year_now = date('Y');
        $start_year = 2018;
        for ($year = $start_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        $model = new PlanReceivingPeriod();
        $model->month = date('m');
        $model->year = date('Y');
        if ($model->load($_GET))
        {

        }

        $periode = $model->year . $model->month;

    	/*$inspection_data_arr = InspectionReportView::find()
    	->where([
    		'periode' => $periode
    	])
    	->andWhere('total_lot_out > 0 OR total_repair > 0')
    	->orderBy('proddate')
    	->all();*/

        $inspection_data_arr = SernoInput::find()
        ->select([
            'period' => 'extract(year_month from proddate)',
            'week_no' => 'week(proddate, 4)',
            'proddate',
            'total_data' => 'COUNT(proddate)',
            'total_no_check' => 'SUM((CASE WHEN ((qa_ng = \'\') and (qa_ok = \'\')) then 1 ELSE 0 END))',
            'total_ok' => 'SUM((CASE WHEN ((qa_ng = \'\') and (qa_ok = \'OK\')) then 1 ELSE 0 END))',
            'total_lot_out' => 'SUM((CASE WHEN ((qa_ng <> \'\') and (qa_result <> 2)) then 1 ELSE 0 END))',
            'total_repair' => 'SUM((CASE WHEN ((qa_ng <> \'\') and (qa_result = 2)) then 1 ELSE 0 END))',
        ])
        ->where([
            'extract(year_month from proddate)' => $periode
        ])
        ->groupBy('week_no, proddate')
        ->having([

        ])
        ->all();

    	$tmp_data = [];
        $tmp_data2 = [];
    	foreach ($inspection_data_arr as $inspection_data) {
    		$categories[] = $inspection_data->proddate;
    		
    		$tmp_data[] = [
    			'y' => $inspection_data->total_lot_out == 0 ? null : (int)$inspection_data->total_lot_out,
    			'url' => Url::to(['production-inspection/index', 'proddate' => $inspection_data->proddate, 'status' => 'LOT OUT'])
    		];
            $tmp_data2[] = [
                'y' => $inspection_data->total_repair == 0 ? null : (int)$inspection_data->total_repair,
                'url' => Url::to(['production-inspection/index', 'proddate' => $inspection_data->proddate, 'status' => 'REPAIR'])
            ];
    	}

    	$data = [
            [
                'name' => 'Repair 個別不良',
                'data' => $tmp_data2,
                'color' => 'rgba(0, 0, 255, 0.5)'
            ],
    		[
    			'name' => 'Lot Out ロットアウト',
    			'data' => $tmp_data,
    			'color' => 'rgba(255, 0, 0, 0.5)'
    		],
            
    	];

    	return $this->render('production-monthly-inspection', [
    		'data' => $data,
    		'categories' => $categories,
    		'model' => $model,
    		'year_arr' => $year_arr,
    		'month_arr' => $month_arr,
    		''
    	]);
	}

	public function actionPartsPickingStatus()
	{
		$this->layout = 'clean';
		date_default_timezone_set('Asia/Jakarta');
        set_time_limit(500);
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

            $tmp_data_ordered = [];
            $tmp_data_started = [];
            $tmp_data_completed = [];
            $tmp_data_handover = [];
    		foreach ($visual_picking_arr as $visual_picking) {
    			if ($week_no == $visual_picking->week) {
    				$tmp_category[] = date('Y-m-d', strtotime($visual_picking->req_date));

    				$open_qty = $visual_picking->slip_open;
    				$close_qty = $visual_picking->slip_close;

                    $ordered_qty = $visual_picking->total_ordered;
                    $started_qty = $visual_picking->total_started;
                    $completed_qty = $visual_picking->total_completed;
                    $handover_qty = $visual_picking->slip_close;
    				$total_qty = $visual_picking->slip_count;

    				$open_percentage = 0;
    				$close_percentage = 0;

                    $ordered_percentage = 0;
                    $started_percentage = 0;
                    $completed_percentage = 0;
                    $handover_percentage = 0;
    				if ($total_qty > 0) {
    					$open_percentage = round((($open_qty / $total_qty) * 100), 2);
    					$close_percentage = round((($close_qty / $total_qty) * 100), 2);

                        $ordered_percentage = round((($ordered_qty / $total_qty) * 100), 2);
                        $started_percentage = round((($started_qty / $total_qty) * 100), 2);
                        $completed_percentage = round((($completed_qty / $total_qty) * 100), 2);
                        $handover_percentage = round((($handover_qty / $total_qty) * 100), 2);
    				}

                    $tmp_data_ordered[] = [
                        'y' => $ordered_percentage == 0 ? null : $ordered_percentage,
                        //'remark' => $this->partsPickingGetRemark($visual_picking->req_date, $visual_picking->analyst, [1, 2], 'O')
                    ];
                    $tmp_data_started[] = [
                        'y' => $started_percentage == 0 ? null : $started_percentage,
                        //'remark' => $this->partsPickingGetRemark($visual_picking->req_date, $visual_picking->analyst, 3, 'O')
                    ];
                    $tmp_data_completed[] = [
                        'y' => $completed_percentage == 0 ? null : $completed_percentage,
                        //'remark' => $this->partsPickingGetRemark($visual_picking->req_date, $visual_picking->analyst, [4, 5], 'O')
                    ];
                    $tmp_data_handover[] = [
                        'y' => $handover_percentage == 0 ? null : $handover_percentage,
                        //'remark' => $this->partsPickingGetRemark($visual_picking->req_date, $visual_picking->analyst, 5, 'C')
                    ];

    			}
    		}
    		$data[$week_no][] = [
    			'category' => $tmp_category,
                'data' => [
                    [
                        'name' => 'ORDERED （受注）',
                        'data' => $tmp_data_ordered,
                        'color' => 'rgba(200, 200, 200, 0.5)',
                    ],
                    [
                        'name' => 'STARTED (ピッキング中)',
                        'data' => $tmp_data_started,
                        'color' => 'rgba(240, 240, 0, 0.5)',
                    ],
                    [
                        'name' => 'COMPLETED (ピッキング完了)',
                        'data' => $tmp_data_completed,
                        'color' => 'rgba(0, 150, 255, 0.5)',
                    ],
                    [
                        'name' => 'HANDOVER （後工程に引渡し）',
                        'data' => $tmp_data_handover,
                        'color' => 'rgba(0, 240, 0, 0.5)',
                    ],
                ],
    		];
    	}

    	return $this->render('parts-picking-status', [
    		'model' => $model,
    		'dropdown_loc' => $dropdown_loc,
    		'data' => $data,
    		'this_week' => $this_week
    	]);
	}

	/*public function partsPickingGetRemark($req_date, $analyst, $stage_id, $stat)
    {
    	$data_arr = VisualPickingView::find()
    	->where([
    		'req_date' => $req_date,
    		'analyst' => $analyst,
            'stage_id' => $stage_id,
            'stat' => $stat,
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
            <th class="text-center">PTS Note</th>
		</tr>'
		;

		foreach ($data_arr as $value) {
            $req_date = $value['req_date'] == null ? '-' : date('Y-m-d', strtotime($value['req_date']));
            $start_date = $value['start_date'] == null ? '-' : date('Y-m-d H:i:s', strtotime($value['start_date']));
            $completed_date = $value['completed_date'] == null ? '-' : date('Y-m-d H:i:s', strtotime($value['completed_date']));
			$data .= '
				<tr>
					<td class="text-center">' . $value['set_list_no'] . '</td>
					<td class="text-center">' . $value['parent'] . '</td>
					<td>' . $value['parent_desc'] . '</td>
					<td class="text-center">' . $req_date . '</td>
					<td class="text-center">' . $value['plan_qty'] . '</td>
					<td class="text-center">' . $value['part_count'] . '</td>
					<td class="text-center">' . $value['man_power'] . '</td>
                    <td class="text-center">' . $start_date . '</td>
                    <td class="text-center">' . $completed_date . '</td>
					<td class="text-center">' . $value['stage_desc'] . '</td>
                    <td>' . $value['pts_note'] . '</td>
				</tr>
				';
		}

		$data .= '</table>';
		return $data;
    }*/

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