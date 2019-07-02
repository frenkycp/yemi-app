<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

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

//ng-report
use app\models\MntCorrectiveView;

//monthly-overtime-by-section
use app\models\SplView;
use app\models\Karyawan;
use app\models\CostCenter;
use app\models\FiscalTbl;

//hrga-spl-report-daily
use app\models\SplOvertimeBudget;

//overtime-monthly-summary
use app\models\search\OvertimeMonthlySummarySearch;

//top-overtime-data
use app\models\search\TopOvertimeDataSearch;

//hr-complaint
use app\models\search\HrComplaintSearch;
use app\models\HrComplaint;

//plan receiving calendar
use app\models\PlanReceiving;

use app\models\MachineIotCurrentEffLog;

//go machine order
use app\models\GojekOrderView01;

class DisplayController extends Controller
{
    public function actionGoMachineOrder()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [];

        $model = new \yii\base\DynamicModel([
            'request_date'
        ]);
        $model->addRule(['request_date'], 'required');
        $model->request_date = date('Y-m-d');

        /*if (\Yii::$app->request->get('request_date') !== null) {
            $model->request_date = \Yii::$app->request->get('request_date');
        }*/

        $model->load($_GET);

        $tmp_order_arr = GojekOrderView01::find()
        ->select([
            'request_ymd', 'request_hour',
            'qty_open' => 'SUM(CASE WHEN STAT = \'O\' THEN 1 ELSE 0 END)',
            'qty_close' => 'SUM(CASE WHEN STAT = \'C\' THEN 1 ELSE 0 END)',
        ])
        ->where([
            'source' => 'MCH',
            'request_ymd' => $model->request_date
        ])
        ->groupBy('request_ymd, request_hour')
        ->orderBy('request_hour')
        ->all();
        //echo $model->request_date;
        //echo count($tmp_order_arr);

        $tmp_data = [];
        foreach ($tmp_order_arr as $key => $value) {
            $tmp_request_date = (strtotime($value->request_ymd . ' ' . $value->request_hour . " +7 hours") * 1000);
            if ($value->qty_open > 0) {
                $tmp_data['open'][] = [
                    'x' => $tmp_request_date,
                    'y' => (int)$value->qty_open,
                    'url' => Url::to(['machine-order-get-remark', 'request_ymd' => $value->request_ymd, 'request_hour' => $value->request_hour, 'STAT' => 'O']),
                ];
            }
            
            if ($value->qty_close > 0) {
                $tmp_data['close'][] = [
                    'x' => $tmp_request_date,
                    'y' => (int)$value->qty_close,
                    'url' => Url::to(['machine-order-get-remark', 'request_ymd' => $value->request_ymd, 'request_hour' => $value->request_hour, 'STAT' => 'C']),
                ];
            }
            
        }

        $data = [
            [
                'name' => 'ORDER (OPEN)',
                'data' => $tmp_data['open'],
                'color' => 'rgba(255, 0, 0, 0.7)',
            ],
            [
                'name' => 'ORDER (CLOSE)',
                'data' => $tmp_data['close'],
                'color' => 'rgba(0, 255, 0, 0.7)',
            ],
        ];

        return $this->render('go-machine-order', [
            'data' => $data,
            'model' => $model,
        ]);
    }

    public function actionMachineOrderGetRemark($request_ymd, $request_hour, $STAT)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($STAT == 'O') {
            $status = 'OPEN';
        } else {
            $status = 'CLOSE';
        }
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Request ' . $status . ' <small>(' . $request_ymd . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 12px;">
            <th class="text-center">Req. Time</th>
            <th class="text-center">Slip ID</th>
            <th>Location</th>
            <th>Machine</th>
            <th>Model</th>
            <th>Requestor</th>
            <th>Driver</th>
        </tr>';

        $data_arr = GojekOrderView01::find()
        ->where([
            'source' => 'MCH',
            'request_ymd' => $request_ymd,
            'request_hour' => $request_hour,
            'STAT' => $STAT
        ])
        ->orderBy('request_date')
        ->all();

        $no = 1;
        foreach ($data_arr as $key => $value) {
            $remark .= '<tr style="font-size: 12px;">
                <td class="text-center" style="font-weight: bold;">' . date('H:i', strtotime($value->request_date)) . '</td>
                <td class="text-center">' . $value->slip_id . '</td>
                <td>' . $value->to_loc . '</td>
                <td>' . $value->item_desc . '</td>
                <td>' . $value->model . '</td>
                <td>' . $value->NAMA_KARYAWAN . '</td>
                <td>' . $value->GOJEK_DESC . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionMachineHourlyRank()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $data = [];
        $last_hour = date('Y-m-d H:i:s', strtotime(' -1 hour'));
        if ((int)date('i') <= 5) {
            $last_hour = date('Y-m-d H:i:s', strtotime($last_hour . ' -1 hour'));
        }

        $posting_date = date('Y-m-d', strtotime($last_hour));
        $jam = date('G', strtotime($last_hour));

        //echo $posting_date . ' || ' . $jam;

        $tmp_eff_arr = MachineIotCurrentEffLog::find()
        ->where([
            'posting_date' => $posting_date,
            'jam' => $jam
        ])
        ->orderBy('pct, mesin_description')
        ->all();

        $tmp_data = [];
        $categories = [];
        foreach ($tmp_eff_arr as $key => $value) {
            $categories[] = $value->mesin_description;
            $tmp_data[] = (int)$value->pct;
        }

        $data = [
            [
                'name' => 'Utility',
                'data' => $tmp_data,
                'color' => 'rgba(0, 255, 0, 0.7)',
                'showInLegend' => false,
            ],
        ];

        return $this->render('machine-hourly-rank', [
            'data' => $data,
            'categories' => $categories,
            'last_hour' => $last_hour,
        ]);
    }

    public function actionMachineDailyRank()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $data = [];
        $last_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));

        $tmp_eff_arr = MachineIotCurrentEffLog::find()
        ->select([
            'posting_shift', 'mesin_id', 'mesin_description',
            'hijau' => 'SUM(hijau)',
            'hijau_biru' => 'SUM(hijau_biru)',
            'hijau_biru_kuning' => 'SUM(hijau_biru + kuning)',
            'pct' => 'AVG(pct)'
        ])
        ->where([
            'posting_shift' => $last_date
        ])
        ->groupBy('mesin_id, mesin_description, posting_shift')
        ->all();

        $tmp_data = [];
        foreach ($tmp_eff_arr as $key => $value) {
            $tmp_util = 0;
            if ($value->hijau_biru_kuning > 0) {
                $tmp_util = round(($value->hijau / $value->hijau_biru_kuning) * 100, 1);
            }
            $tmp_data[$value->mesin_description] = $tmp_util;
        }

        asort($tmp_data);

        $tmp_data2 = [];
        $categories = [];
        foreach ($tmp_data as $key => $value) {
            $categories[] = $key;
            $tmp_data2[] = [
                'y' => $value
            ];
        }

        $data = [
            [
                'name' => 'Utility',
                'data' => $tmp_data2,
                'color' => 'rgba(0, 255, 0, 0.7)',
                'showInLegend' => false,
            ],
        ];
        //print_r($tmp_data);

        return $this->render('machine-daily-rank', [
            'data' => $data,
            'categories' => $categories,
            'last_date' => $last_date,
        ]);
    }

    public function actionGetDailyReceiving()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tmp_data = PlanReceiving::find()
        ->select([
            'receiving_date', 'vendor_name',
            'total_qty' => 'SUM(QTY)'
        ])
        ->where('completed_time IS NULL')
        ->groupBy('receiving_date, vendor_name')
        ->orderBy('receiving_date, vendor_name')
        ->all();

        $data = [];
        foreach ($tmp_data as $key => $value) {
            $data[] = [
                'title' => strtoupper($value->vendor_name) . ' - ' . $value->total_qty,
                'start' => (strtotime($value->receiving_date . " +7 hours") * 1000),
                'allDay' => true
            ];
        }

        return json_encode($data);
    }

    public function actionReceivingCalendar()
    {
        $this->layout = 'clean';
        return $this->render('receiving-calendar');
    }

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

    public function actionDprLineEfficiency()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $line = 'HS';
        $today = date('Y-m-d');

        $target_eff_arr = \Yii::$app->params['line_eff_target'];
        $target_eff = 100;
        if (isset($target_eff_arr[$line])) {
            $target_eff = $target_eff_arr[$line];
        }

        $data_arr = SernoInput::find()
        ->where([
            'proddate' => $today,
            'line' => $line
        ])
        ->orderBy('waktu')
        ->all();

        $tmp_data = [];
        foreach ($data_arr as $key => $value) {
            $post_time = (strtotime($value->proddate . ' ' . $value->waktu . " +7 hours") * 1000);
            $eff = null;
            if ($value->mp_time > 0) {
                $eff = round(($value->qty_time / $value->mp_time) * 100, 1);
            }

            $tmp_data[] = [
                'x' => $post_time,
                'y' => $eff
            ];
        }

        $series = [
            [
                'data' => $tmp_data,
                'name' => 'Efficiency',
                //'lineWidth' => 0.5
            ],
        ];

        return $this->render('dpr-line-efficiency', [
            'series' => $series,
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

	public function actionNgReport()
	{
		$this->layout = 'clean';
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}
		$period = $year . $month;

		$corrective_data_arr = MntCorrectiveView::find()
		->where([
			'period' => $period
		])
		->orderBy('period, week_no, issued_date')
		->asArray()
		->all();

		$tmp_data = [];
		foreach ($corrective_data_arr as $key => $corrective_data) {
			$week_no = $corrective_data['week_no'];
			$issued_date = $corrective_data['issued_date'];
			$issued_date2 = (strtotime($issued_date . " +7 hours") * 1000);
			$total_open = $corrective_data['total_open'];
			$total_close = $corrective_data['total_close'];
			$tmp_data[$week_no]['open'][] = [
				'x' => $issued_date2,
				'y' => $total_open == 0 ? null : (int)$total_open,
				'url' => Url::to(['mesin-check-ng/index', 'repair_status' => 'O', 'mesin_last_update' => $issued_date]),
                'qty' => $total_open,
			];
			$tmp_data[$week_no]['close'][] = [
				'x' => $issued_date2,
				'y' => (int)$total_close,
				'url' => Url::to(['mesin-check-ng/index', 'repair_status' => 'C', 'mesin_last_update' => $issued_date]),
                'qty' => $total_close,
			];
		}

		$data = [];
		foreach ($tmp_data as $key => $value) {
			$data[$key] = [
				[
					'name' => 'OPEN',
					'data' => $value['open'],
					'color' => 'rgba(200, 200, 200, 0.7)',
				],
				[
					'name' => 'CLOSE',
					'data' => $value['close'],
					'color' => 'rgba(0, 200, 0, 0.7)',
				]
			];
		}

		return $this->render('ng-report', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}

	public function actionMonthlyOvertimeBySection()
	{
		$this->layout = 'clean';
		$fiscal = FiscalTbl::find()
		->select('FISCAL')
		->where([
			'PERIOD' => date('Ym')
		])
		->one()
		->FISCAL;
		if ($fiscal == null) {
			$fiscal = FiscalTbl::find()
			->select([
				'FISCAL' => 'MAX(FISCAL)'
			])
			->one()
			->FISCAL;
		}

		if (\Yii::$app->request->get('id') == 'fa') {
			$section = '320';
		} elseif (\Yii::$app->request->get('id') == 'pnt') {
			$section = '330';
		} elseif (\Yii::$app->request->get('id') == 'ww') {
			$section = '300';
		}

		if (\Yii::$app->request->get('fiscal') !== null) {
			$fiscal = \Yii::$app->request->get('fiscal');
		}

		if (\Yii::$app->request->get('section') !== null) {
			$section = \Yii::$app->request->get('section');
		}

		$period_data_arr = FiscalTbl::find()
		->select('PERIOD')
		->where([
			'FISCAL' => $fiscal
		])
		->orderBy('PERIOD')
		->asArray()
		->all();

		$categories = [];
		foreach ($period_data_arr as $key => $value) {
			$categories[] = $value['PERIOD'];
		}

		$section_arr = ArrayHelper::map(CostCenter::find()->select('CC_ID, CC_DESC')->groupBy('CC_ID, CC_DESC')->orderBy('CC_DESC')->all(), 'CC_ID', 'CC_DESC');
		$section_arr['ALL'] = '-- ALL SECTIONS --';
		//asort($section_arr);

		if ($section == 'ALL') {
			$karyawan_arr = SplView::find()
			->select([
				'NIK', 'NAMA_KARYAWAN', 'CC_ID', 'CC_DESC'
			])
			->where([
				'PERIOD' => $categories,
			])
			->andWhere('NIK IS NOT NULL')
			->groupBy('NIK, NAMA_KARYAWAN, CC_ID, CC_DESC')
			->asArray()
			->all();

			$overtime_data = SplView::find()
			->select([
				'PERIOD',
				'NIK',
				'NAMA_KARYAWAN',
				'CC_ID',
				'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
			])
			->where([
				'PERIOD' => $categories,
			])
			->groupBy('PERIOD, NIK, NAMA_KARYAWAN, CC_ID')
			->orderBy('NIK, PERIOD')
			->asArray()
			->all();
		} else {
			$karyawan_arr = SplView::find()
			->select([
				'NIK', 'NAMA_KARYAWAN', 'CC_ID', 'CC_DESC'
			])
			->where([
				'CC_ID' => $section,
				'PERIOD' => $categories,
			])
			->andWhere('NIK IS NOT NULL')
			->groupBy('NIK, NAMA_KARYAWAN, CC_ID, CC_DESC')
			->asArray()
			->all();

			$overtime_data = SplView::find()
			->select([
				'PERIOD',
				'NIK',
				'NAMA_KARYAWAN',
				'CC_ID',
				'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
			])
			->where([
				'PERIOD' => $categories,
				'CC_ID' => $section
			])
			->groupBy('PERIOD, NIK, NAMA_KARYAWAN, CC_ID')
			->orderBy('NIK, PERIOD')
			->asArray()
			->all();
		}

		$data = [];
		foreach ($karyawan_arr as $karyawan) {
			$tmp_data = [];
			foreach ($categories as $period_value) {
				$hour = 0;
				foreach ($overtime_data as $value) {
					if ($value['NIK'] == $karyawan['NIK'] && $period_value == $value['PERIOD']) {
						$hour = $value['NILAI_LEMBUR_ACTUAL'];
						continue;
					}
				}
				$tmp_data[] = [
					'y' => round($hour, 2),
					'url' => Url::to(['get-remark', 'nik' => $karyawan['NIK'], 'nama_karyawan' => $karyawan['NAMA_KARYAWAN'], 'period' => $period_value])
				];
			}
			$data[] = [
				'name' => $karyawan['NIK'] . ' - ' . $karyawan['NAMA_KARYAWAN'] . ' (' . $karyawan['CC_DESC'] . ')',
				'data' => $tmp_data,
				'showInLegend' => false,
				'lineWidth' => 0.8,
				'color' => new JsExpression('Highcharts.getOptions().colors[0]')
			];
		}

    	return $this->render('monthly-overtime-by-section', [
			'data' => $data,
			'fiscal' => $fiscal,
			'section' => $section,
			'categories' => $categories,
			'section_arr' => $section_arr
		]);
	}

	public function actionHrgaSplReportDaily()
	{
		$this->layout = 'clean';
		$title = '';
    	$subtitle = '';
    	$category = [];
    	$data = [];
        $data2 = [];
    	$cc_group_arr = [];
    	$category_arr = [];
    	$tgl_lembur_arr = [];

        $year_arr = [];
        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $min_year = SplView::find()->select([
            'min_year' => 'MIN(FORMAT(TGL_LEMBUR, \'yyyy\'))'
        ])->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        $model = new PlanReceivingPeriod();
        $model->month = date('m');
        $model->year = date('Y');
        if ($model->load($_GET))
        {

        }

        $period = $model->year . '-' . $model->month;

        $spl_data = SplView::find()
        ->select([
            'TGL_LEMBUR' => 'TGL_LEMBUR',
            'CC_GROUP' => 'CC_GROUP',
            'JUMLAH' => 'COUNT(NIK)',
            'total_lembur' => 'SUM(NILAI_LEMBUR_ACTUAL)'
        ])
        ->where('NIK IS NOT NULL')
        ->andWhere('CC_GROUP IS NOT NULL')
        ->andWhere('NILAI_LEMBUR_ACTUAL IS NOT NULL')
        ->andWhere([
            'FORMAT(TGL_LEMBUR, \'yyyy-MM\')' => $period
        ])
        ->groupBy('CC_GROUP, TGL_LEMBUR')
        ->orderBy('TGL_LEMBUR, CC_GROUP')
        ->all();

        foreach ($spl_data as $value) {
            if(!in_array($value->CC_GROUP, $cc_group_arr)){
                $cc_group_arr[] = $value->CC_GROUP;
            }
            if (!in_array($value->TGL_LEMBUR, $tgl_lembur_arr)) {
                $tgl_lembur_arr[] = $value->TGL_LEMBUR;
            }
        }

        $prod_total_jam_lembur = 0;
        $others_total_jam_lembur = 0;
        foreach ($cc_group_arr as $cc_group) {
            $tmp_data = [];
            $tmp_data2 = [];
            foreach ($tgl_lembur_arr as $tgl_lembur) {
                $is_found = false;
                
                foreach ($spl_data as $value) {
                    if ($tgl_lembur == $value->TGL_LEMBUR && $cc_group == $value->CC_GROUP) {
                        if ($value->CC_GROUP == 'PRODUCTION') {
                            $prod_total_jam_lembur += $value->total_lembur;
                        } else {
                            $others_total_jam_lembur += $value->total_lembur;
                        }
                        $tmp_data[] = [
                            'y' => (int)$value->JUMLAH,
                            'url' => Url::to(['get-remark', 'tgl_lembur' => $tgl_lembur, 'cc_group' => $cc_group])
                            //'remark' => $this->getDetailEmpRemark($tgl_lembur, $cc_group)
                        ];
                        $tmp_data2[] = [
                            'y' => (float)$value->total_lembur,
                            'url' => Url::to(['get-remark', 'tgl_lembur' => $tgl_lembur, 'cc_group' => $cc_group])
                            //'remark' => $this->getDetailEmpRemark($tgl_lembur, $cc_group)
                        ];
                        $is_found = true;
                    }
                }
                if (!$is_found) {
                    $tmp_data[] = null;
                    $tmp_data2[] = null;
                }
                if (!in_array($tgl_lembur, $category_arr)) {
                    $category_arr[] = $tgl_lembur;
                }
            }
            $data[] = [
                'name' => $cc_group,
                'data' => $tmp_data,
            ];
            $data2[] = [
                'name' => $cc_group,
                'data' => $tmp_data2,
            ];
        }

        foreach ($category_arr as $key => $value) {
            $category_arr[$key] = date('j', strtotime($value));
        }

        $overtime_budget = $this->getOvertimeBudget($model->year . $model->month, 1);
        $overtime_budget2 = $this->getOvertimeBudget($model->year . $model->month, 2);

    	return $this->render('hrga-spl-report-daily', [
            'model' => $model,
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'category' => $category_arr,
    		'data' => $data,
            'data2' => $data2,
            'year_arr' => $year_arr,
            'month_arr' => $month_arr,
            'prod_total_jam_lembur' => $prod_total_jam_lembur,
            'others_total_jam_lembur' => $others_total_jam_lembur,
            'overtime_budget' => $overtime_budget,
            'overtime_budget2' => $overtime_budget2,
            //'budget_progress' => 120,
            'budget_progress' => $overtime_budget == 0 ? 0 : round((($prod_total_jam_lembur / $overtime_budget) * 100), 2),
            'budget_progress2' => $overtime_budget2 == 0 ? 0 : round((($others_total_jam_lembur / $overtime_budget2) * 100), 2)
    	]);
	}

	public function actionOvertimeMonthlySummary()
	{
		$this->layout = 'clean';
		$searchModel  = new OvertimeMonthlySummarySearch;

		$year = date('Y');
        $month = date('m');

        $searchModel->PERIOD = $year . $month;
        
        if (\Yii::$app->request->get('PERIOD') !== null) {
			$searchModel->PERIOD = \Yii::$app->request->get('PERIOD');
		}

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('overtime-monthly-summary', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionTopOvertimeData()
	{
		$this->layout = 'clean';
		$searchModel  = new TopOvertimeDataSearch;

		$year = date('Y');
        $month = date('m');

        $searchModel->PERIOD = $year . $month;
        
        if (\Yii::$app->request->get('PERIOD') !== null) {
			$searchModel->PERIOD = \Yii::$app->request->get('PERIOD');
		}

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('top-overtime-data', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

    public function actionHrComplaint()
    {
        $this->layout = 'clean';
        $searchModel  = new HrComplaintSearch;
        $searchModel->category = 'HR';
        $dataProvider = $searchModel->search($_GET);

        $total_waiting = HrComplaint::find()
        ->where([
            'status' => 0,
            'category' => 'HR',
        ])
        ->count();

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('hr-complaint', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'total_waiting' => $total_waiting,
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

    public function getOvertimeBudget($period, $category_id)
    {
        $data = SplOvertimeBudget::find()
        ->where([
            'period' => $period,
            'category_id' => $category_id
        ])
        ->one();

        return $data->overtime_budget != null ? $data->overtime_budget : 0;
    }
}