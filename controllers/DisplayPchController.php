<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\PcPiVariance;
use app\models\StoreOnhandWsus;
use app\models\StorePiItem;
use app\models\StorePiItemLog;
use app\models\BookingShipTrack02;
use app\models\PickingLocation;
use app\models\VisualPickingView02;
use app\models\VisualPickingView;

class DisplayPchController extends Controller
{
    public function actionRdrProgress($value='')
    {
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        return $this->render('rdr-progress', [
            'model' => $model,
        ]);
    }

    public function getRemark($req_date, $analyst, $stage_id, $stat)
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

                    if (date('Y-m-d', strtotime($visual_picking->req_date)) == date('Y-m-d')) {
                        $this_week = $visual_picking->week;
                    }

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

                    /*$tmp_data_open[] = [
                        'y' => $open_percentage == 0 ? null : $open_percentage,
                        'remark' => $this->getRemark($visual_picking->req_date, $visual_picking->analyst, 1)
                    ];
                    $tmp_data_close[] = [
                        'y' => $close_percentage == 0 ? null : $close_percentage,
                        'remark' => $this->getRemark($visual_picking->req_date, $visual_picking->analyst, 0)
                    ];*/

                    $tmp_data_ordered[] = [
                        'y' => $ordered_percentage == 0 ? null : $ordered_percentage,
                        'remark' => $this->getRemark($visual_picking->req_date, $visual_picking->analyst, [1, 2], 'O')
                    ];
                    $tmp_data_started[] = [
                        'y' => $started_percentage == 0 ? null : $started_percentage,
                        'remark' => $this->getRemark($visual_picking->req_date, $visual_picking->analyst, 3, 'O')
                    ];
                    $tmp_data_completed[] = [
                        'y' => $completed_percentage == 0 ? null : $completed_percentage,
                        'remark' => $this->getRemark($visual_picking->req_date, $visual_picking->analyst, [4, 5], 'O')
                    ];
                    $tmp_data_handover[] = [
                        'y' => $handover_percentage == 0 ? null : $handover_percentage,
                        'remark' => $this->getRemark($visual_picking->req_date, $visual_picking->analyst, 5, 'C')
                    ];

                }
            }
            $data[$week_no][] = [
                'category' => $tmp_category,
                /*'data' => [
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
                ]*/
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

    public function actionMrsDdsDeparture()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $data = BookingShipTrack02::find()
        ->where([
            'STAT_ID' => 3,
            'TRANS_MTHD' => ['MRS', 'DDS']
        ])
        ->andWhere([
            '>=', 'PICKUP_PLAN', date('Y-m-d', strtotime(' -1 month'))
        ])
        ->andWhere(['>', 'BO_QTY', 0])
        ->orderBy('USER_DESC, BOOKING_ID')
        ->asArray()
        ->all();

        return $this->render('mrs-dds-departure', [
            'data' => $data,
        ]);
    }

    public function actionMonthlyStockTakeGetRemark($period, $area, $pi_stage)
    {
        $status_arr = [
            0 => [
                'label' => 'OPEN',
                'color' => '#FF0000',
            ],
            1 => [
                'label' => 'COUNT 1',
                'color' => '#00d0fa',
            ],
            2 => [
                'label' => 'COUNT 2',
                'color' => '#ffff00',
            ],
            3 => [
                'label' => 'AUDIT 1',
                'color' => '#77ff00',
            ],
            4 => [
                'label' => 'AUDIT 2',
                'color' => '#00ff00',
            ],
        ];

        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Area : ' . $area . ' , Status : ' . $status_arr[$pi_stage]['label'] . ' <small>(' . $period . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 14px;">
            <th class="text-center">No.</th>
            <th class="text-center">Slip No.</th>
            <th class="text-center" style="min-width: 90px;">Item</th>
            <th class="">Item Description</th>
            <th class="text-center">Rack</th>
            <th class="text-center">Rack Loc.</th>
        </tr>';

        $tmp_ng_arr = StorePiItem::find()
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_PERIOD' => $period,
            'AREA' => $area,
            'PI_STAGE' => $pi_stage
        ])
        ->all();

        $no = 1;
        foreach ($tmp_ng_arr as $key => $value) {
            $remark .= '<tr style="font-size: 14px;">
                <td class="text-center">' .$no . '</td>
                <td class="text-center">' .$value->SLIP . '</td>
                <td class="text-center">' .$value->ITEM . '</td>
                <td class="">' .$value->ITEM_DESC . '</td>
                <td class="text-center">' .$value->RACK . '</td>
                <td class="text-center">' .$value->RACK_LOC . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionMonthlyStockTake($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $drilldown = [];
        

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');
        $model->period = date('Ym');

        $period_dropdown_arr = ArrayHelper::map(StorePiItem::find()->select('PI_PERIOD')->where('PI_PERIOD IS NOT NULL')->groupBy('PI_PERIOD')->orderBy('PI_PERIOD DESC')->all(), 'PI_PERIOD', 'PI_PERIOD');

        if ($model->load($_GET)) {

        }

        $tmp_result_arr = StorePiItem::find()
        ->select([
            'total_open' => 'SUM(CASE WHEN PI_STAGE = 0 THEN 1 ELSE 0 END)',
            'total1' => 'SUM(CASE WHEN PI_STAGE = 1 THEN 1 ELSE 0 END)',
            'total2' => 'SUM(CASE WHEN PI_STAGE = 2 THEN 1 ELSE 0 END)',
            'total3' => 'SUM(CASE WHEN PI_STAGE = 3 THEN 1 ELSE 0 END)',
            'total4' => 'SUM(CASE WHEN PI_STAGE = 4 THEN 1 ELSE 0 END)',
            'total_all' => 'COUNT(*)',
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_PERIOD' => $model->period
        ])
        ->andWhere('PI_STAGE IS NOT NULL')
        //->andWhere(['<>', 'PIC', '-'])
        ->one();

        $total_all_slip = $tmp_result_arr->total_all;
        $status_arr = [
            0 => [
                'label' => 'OPEN',
                'color' => '#FF0000',
            ],
            1 => [
                'label' => 'COUNT 1',
                'color' => '#00d0fa',
            ],
            2 => [
                'label' => 'COUNT 2',
                'color' => '#ffff00',
            ],
            3 => [
                'label' => 'AUDIT 1',
                'color' => '#77ff00',
            ],
            4 => [
                'label' => 'AUDIT 2',
                'color' => '#00ff00',
            ],
        ];

        $data = [
            [
                'name' => $status_arr[1]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total1,
                        'drilldown' => $status_arr[1]['label'],
                        
                    ],
                ],
                'color' => $status_arr[1]['color'],
            ],
            [
                'name' => $status_arr[2]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total2,
                        'drilldown' => $status_arr[2]['label'],
                        
                    ],
                ],
                'color' => $status_arr[2]['color'],
            ],
            [
                'name' => $status_arr[3]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total3,
                        'drilldown' => $status_arr[3]['label'],
                        
                    ],
                ],
                'color' => $status_arr[3]['color'],
            ],
            [
                'name' => $status_arr[4]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total4,
                        'drilldown' => $status_arr[4]['label'],
                        
                    ],
                ],
                'color' => $status_arr[4]['color'],
            ],
            [
                'name' => $status_arr[0]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total_open,
                        'drilldown' => $status_arr[0]['label'],
                        
                    ],
                ],
                'color' => $status_arr[0]['color'],
            ],
        ];

        $area_arr = StorePiItem::find()
        ->select('AREA')
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_PERIOD' => $model->period,
        ])
        ->andWhere(['<>', 'AREA', '-'])
        ->andWhere(['<>', 'AREA', ''])
        ->andWhere('AREA IS NOT NULL')
        //->andWhere(['<>', 'PIC', '-'])
        ->groupBy('AREA')
        ->orderBy('AREA')
        ->all();

        $categories = [];
        $tmp_data = [];
        foreach ($status_arr as $key => $status) {
            
            $tmp_drilldown_open = StorePiItem::find()->select([
                'AREA', 'total' => 'COUNT(*)'
            ])
            ->where([
                'SLIP_STAT' => 'USED',
                'PI_PERIOD' => $model->period,
                'PI_STAGE' => $key
            ])
            //->andWhere(['<>', 'PIC', '-'])
            ->groupBy('AREA')->orderBy('AREA')->all();

            foreach ($area_arr as $area) {
                if (!in_array($area->AREA, $categories)) {
                    $categories[] = $area->AREA;
                }
                $tmp_total_value = 0;
                foreach ($tmp_drilldown_open as $value) {
                    if ($area->AREA == $value->AREA) {
                        $tmp_total_value = $value->total;
                    }
                }
                $tmp_data[$key][] = [
                    'y' => (int)$tmp_total_value,
                    'url' => Url::to(['monthly-stock-take-get-remark', 'period' => $model->period, 'area' => $area->AREA, 'pi_stage' => $key])
                ];
            }
            
        }

        $data_new = [];
        $data_new = [
            [
                'name' => $status_arr[1]['label'],
                'data' => $tmp_data[1],
                'color' => $status_arr[1]['color'],
            ],
            [
                'name' => $status_arr[2]['label'],
                'data' => $tmp_data[2],
                'color' => $status_arr[2]['color'],
            ],
            [
                'name' => $status_arr[3]['label'],
                'data' => $tmp_data[3],
                'color' => $status_arr[3]['color'],
            ],
            [
                'name' => $status_arr[4]['label'],
                'data' => $tmp_data[4],
                'color' => $status_arr[4]['color'],
            ],
            [
                'name' => $status_arr[0]['label'],
                'data' => $tmp_data[0],
                'color' => $status_arr[0]['color'],
            ],
        ];

        $start_date = date('Y-m-01', strtotime($model->period . '01'));
        $end_date = date('Y-m-t', strtotime($model->period . '01'));
        $today = date('Y-m-d');
        /*if ($today < $end_date) {
            $end_date = $today;
        }*/

        $begin = new \DateTime(date('Y-m-d', strtotime($start_date)));
        $end   = new \DateTime(date('Y-m-d', strtotime($end_date)));
        
        $log_1 = StorePiItemLog::find()
        ->select([
            'PI_COUNT_01_LAST_UPDATE' => 'FORMAT(PI_COUNT_01_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N',
            'PI_STAGE' => 1
        ])
        ->groupBy(['FORMAT(PI_COUNT_01_LAST_UPDATE, \'yyyy-MM-dd\')'])
        ->all();

        $log_2 = StorePiItemLog::find()
        ->select([
            'PI_COUNT_02_LAST_UPDATE' => 'FORMAT(PI_COUNT_02_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N',
            'PI_STAGE' => 2
        ])
        ->groupBy(['FORMAT(PI_COUNT_02_LAST_UPDATE, \'yyyy-MM-dd\')'])
        ->all();

        $log_3 = StorePiItemLog::find()
        ->select([
            'PI_AUDIT_01_LAST_UPDATE' => 'FORMAT(PI_AUDIT_01_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N',
            'PI_STAGE' => 3
        ])
        ->groupBy(['FORMAT(PI_AUDIT_01_LAST_UPDATE, \'yyyy-MM-dd\')'])
        ->all();

        $log_4 = StorePiItemLog::find()
        ->select([
            'PI_AUDIT_02_LAST_UPDATE' => 'FORMAT(PI_AUDIT_02_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N',
            'PI_STAGE' => 4
        ])
        ->groupBy(['FORMAT(PI_AUDIT_02_LAST_UPDATE, \'yyyy-MM-dd\')'])
        ->all();

        $tmp_data1 = $tmp_data2 = $tmp_data3 = $tmp_data4 = [];
        $tmp_total_slip1 = $tmp_total_slip2 = $tmp_total_slip3 = $tmp_total_slip4 = 0;
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $tgl = $i->format("Y-m-d");
            $post_date = (strtotime($tgl . " +7 hours") * 1000);
            $tmp_pct1 = $tmp_pct2 = $tmp_pct3 = $tmp_pct4 = 0;

            foreach ($log_1 as $key => $value) {
                if ($tgl == $value->PI_COUNT_01_LAST_UPDATE) {
                    $tmp_total_slip1 += $value->total_slip;
                }
            }

            foreach ($log_2 as $key => $value) {
                if ($tgl == $value->PI_COUNT_02_LAST_UPDATE) {
                    $tmp_total_slip2 += $value->total_slip;
                }
            }

            foreach ($log_3 as $key => $value) {
                if ($tgl == $value->PI_AUDIT_01_LAST_UPDATE) {
                    $tmp_total_slip3 += $value->total_slip;
                }
            }

            foreach ($log_4 as $key => $value) {
                if ($tgl == $value->PI_AUDIT_02_LAST_UPDATE) {
                    $tmp_total_slip4 += $value->total_slip;
                }
            }

            if ($total_all_slip > 0) {
                $tmp_pct1 = round(($tmp_total_slip1 / $total_all_slip) * 100, 1);
                $tmp_pct2 = round(($tmp_total_slip2 / $total_all_slip) * 100, 1);
                $tmp_pct3 = round(($tmp_total_slip3 / $total_all_slip) * 100, 1);
                $tmp_pct4 = round(($tmp_total_slip4 / $total_all_slip) * 100, 1);
            }

            if ($tgl > $today) {
                $tmp_pct1 = $tmp_pct2 = $tmp_pct3 = $tmp_pct4 = null;
            }

            $tmp_data1[] = [
                'x' => $post_date,
                'y' => $tmp_pct1
            ];

            $tmp_data2[] = [
                'x' => $post_date,
                'y' => $tmp_pct2
            ];

            $tmp_data3[] = [
                'x' => $post_date,
                'y' => $tmp_pct3
            ];

            $tmp_data4[] = [
                'x' => $post_date,
                'y' => $tmp_pct4
            ];
        }

        $data2 = [
            [
                'name' => $status_arr[1]['label'],
                'data' => $tmp_data1,
                'color' => $status_arr[1]['color']
            ],
            [
                'name' => $status_arr[2]['label'],
                'data' => $tmp_data2,
                'color' => $status_arr[2]['color']
            ],
            [
                'name' => $status_arr[3]['label'],
                'data' => $tmp_data3,
                'color' => $status_arr[3]['color']
            ],
            [
                'name' => $status_arr[4]['label'],
                'data' => $tmp_data4,
                'color' => $status_arr[4]['color']
            ],
        ];

        return $this->render('monthly-stock-take', [
            'model' => $model,
            'data' => $data,
            'data2' => $data2,
            'data_new' => $data_new,
            'categories' => $categories,
            'drilldown' => $drilldown,
            'period_dropdown_arr' => $period_dropdown_arr,
            'total_all_slip' => $total_all_slip,
            'tmp_total_slip1' => $tmp_total_slip1,
            'tmp_total_slip2' => $tmp_total_slip2,
            'tmp_total_slip3' => $tmp_total_slip3,
            'tmp_total_slip4' => $tmp_total_slip4,
        ]);
    }

    public function actionMonthlyStockTakeOld($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $drilldown = [];
        

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');
        $model->period = date('Ym');

        $period_dropdown_arr = ArrayHelper::map(StorePiItem::find()->select('PI_PERIOD')->where('PI_PERIOD IS NOT NULL')->groupBy('PI_PERIOD')->orderBy('PI_PERIOD DESC')->all(), 'PI_PERIOD', 'PI_PERIOD');

        if ($model->load($_GET)) {

        }

        $tmp_result_arr = StorePiItem::find()
        ->select([
            'total_open' => 'SUM(CASE WHEN PI_STAGE = 0 THEN 1 ELSE 0 END)',
            'total1' => 'SUM(CASE WHEN PI_STAGE = 1 THEN 1 ELSE 0 END)',
            'total2' => 'SUM(CASE WHEN PI_STAGE = 2 THEN 1 ELSE 0 END)',
            'total3' => 'SUM(CASE WHEN PI_STAGE = 3 THEN 1 ELSE 0 END)',
            'total4' => 'SUM(CASE WHEN PI_STAGE = 4 THEN 1 ELSE 0 END)',
            'total_all' => 'COUNT(*)',
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_PERIOD' => $model->period
        ])
        ->andWhere('PI_STAGE IS NOT NULL')
        //->andWhere(['<>', 'PIC', '-'])
        ->one();

        $total_all_slip = $tmp_result_arr->total_all;
        $status_arr = [
            0 => [
                'label' => 'OPEN',
                'color' => '#FF0000',
            ],
            1 => [
                'label' => 'COUNT 1',
                'color' => '#00d0fa',
            ],
            2 => [
                'label' => 'COUNT 2',
                'color' => '#ffff00',
            ],
            3 => [
                'label' => 'AUDIT 1',
                'color' => '#77ff00',
            ],
            4 => [
                'label' => 'AUDIT 2',
                'color' => '#00ff00',
            ],
        ];

        $data = [
            [
                'name' => $status_arr[1]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total1,
                        'drilldown' => $status_arr[1]['label'],
                        
                    ],
                ],
                'color' => $status_arr[1]['color'],
            ],
            [
                'name' => $status_arr[2]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total2,
                        'drilldown' => $status_arr[2]['label'],
                        
                    ],
                ],
                'color' => $status_arr[2]['color'],
            ],
            [
                'name' => $status_arr[3]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total3,
                        'drilldown' => $status_arr[3]['label'],
                        
                    ],
                ],
                'color' => $status_arr[3]['color'],
            ],
            [
                'name' => $status_arr[4]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total4,
                        'drilldown' => $status_arr[4]['label'],
                        
                    ],
                ],
                'color' => $status_arr[4]['color'],
            ],
            [
                'name' => $status_arr[0]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total_open,
                        'drilldown' => $status_arr[0]['label'],
                        
                    ],
                ],
                'color' => $status_arr[0]['color'],
            ],
        ];

        $pic_arr = StorePiItem::find()
        ->select('PIC')
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_PERIOD' => $model->period,
        ])
        //->andWhere(['<>', 'PIC', '-'])
        ->groupBy('PIC')
        ->orderBy('PIC')
        ->all();

        foreach ($status_arr as $key => $status) {
            $tmp_data = [];
            $tmp_drilldown_open = StorePiItem::find()->select([
                'PIC', 'total' => 'COUNT(*)'
            ])
            ->where([
                'SLIP_STAT' => 'USED',
                'PI_PERIOD' => $model->period,
                'PI_STAGE' => $key
            ])
            //->andWhere(['<>', 'PIC', '-'])
            ->groupBy('PIC')->orderBy('PIC')->all();

            foreach ($pic_arr as $pic) {
                $tmp_total_value = 0;
                foreach ($tmp_drilldown_open as $value) {
                    if ($pic->PIC == $value->PIC) {
                        $tmp_total_value = $value->total;
                    }
                }
                $tmp_data[] = [
                    'name' => $pic->PIC,
                    'y' => (int)$tmp_total_value,
                    'url' => Url::to(['monthly-stock-take-get-remark', 'period' => $model->period, 'pic' => $pic->PIC])
                ];
            }
            
            if ($key == 0) {
                $drilldown[] = [
                    'id' => $status['label'],
                    'name' => $status['label'],
                    'data' => $tmp_data,
                    'cursor' => 'pointer',
                    'point' => [
                        'events' => [
                            'click' => new JsExpression("
                                function(e){
                                    e.preventDefault();
                                    $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                }
                            "),
                        ]
                    ]
                ];
            } else {
                $drilldown[] = [
                    'id' => $status['label'],
                    'name' => $status['label'],
                    'data' => $tmp_data,
                ];
            }
            
        }

        $start_date = date('Y-m-01', strtotime($model->period . '01'));
        $end_date = date('Y-m-t', strtotime($model->period . '01'));
        $today = date('Y-m-d');
        /*if ($today < $end_date) {
            $end_date = $today;
        }*/

        $begin = new \DateTime(date('Y-m-d', strtotime($start_date)));
        $end   = new \DateTime(date('Y-m-d', strtotime($end_date)));
        
        $log_1 = StorePiItemLog::find()
        ->select([
            'PI_COUNT_01_LAST_UPDATE' => 'FORMAT(PI_COUNT_01_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N'
        ])
        ->groupBy('PI_COUNT_01_LAST_UPDATE')
        ->all();

        $log_2 = StorePiItemLog::find()
        ->select([
            'PI_COUNT_02_LAST_UPDATE' => 'FORMAT(PI_COUNT_02_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N'
        ])
        ->groupBy('PI_COUNT_02_LAST_UPDATE')
        ->all();

        $log_3 = StorePiItemLog::find()
        ->select([
            'PI_AUDIT_01_LAST_UPDATE' => 'FORMAT(PI_AUDIT_01_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N'
        ])
        ->groupBy('PI_AUDIT_01_LAST_UPDATE')
        ->all();

        $log_4 = StorePiItemLog::find()
        ->select([
            'PI_AUDIT_02_LAST_UPDATE' => 'FORMAT(PI_AUDIT_02_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N'
        ])
        ->groupBy('PI_AUDIT_02_LAST_UPDATE')
        ->all();

        $tmp_data1 = $tmp_data2 = $tmp_data3 = $tmp_data4 = [];
        $tmp_total_slip1 = $tmp_total_slip2 = $tmp_total_slip3 = $tmp_total_slip4 = 0;
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $tgl = $i->format("Y-m-d");
            $post_date = (strtotime($tgl . " +7 hours") * 1000);
            $tmp_pct1 = $tmp_pct2 = $tmp_pct3 = $tmp_pct4 = 0;

            foreach ($log_1 as $key => $value) {
                if ($tgl == $value->PI_COUNT_01_LAST_UPDATE) {
                    $tmp_total_slip1 += $value->total_slip;
                }
            }

            foreach ($log_2 as $key => $value) {
                if ($tgl == $value->PI_COUNT_02_LAST_UPDATE) {
                    $tmp_total_slip2 += $value->total_slip;
                }
            }

            foreach ($log_3 as $key => $value) {
                if ($tgl == $value->PI_AUDIT_01_LAST_UPDATE) {
                    $tmp_total_slip3 += $value->total_slip;
                }
            }

            foreach ($log_4 as $key => $value) {
                if ($tgl == $value->PI_AUDIT_02_LAST_UPDATE) {
                    $tmp_total_slip4 += $value->total_slip;
                }
            }

            if ($total_all_slip > 0) {
                $tmp_pct1 = round(($tmp_total_slip1 / $total_all_slip) * 100, 1);
                $tmp_pct2 = round(($tmp_total_slip2 / $total_all_slip) * 100, 1);
                $tmp_pct3 = round(($tmp_total_slip3 / $total_all_slip) * 100, 1);
                $tmp_pct4 = round(($tmp_total_slip4 / $total_all_slip) * 100, 1);
            }

            if ($tgl > $today) {
                $tmp_pct1 = $tmp_pct2 = $tmp_pct3 = $tmp_pct4 = null;
            }

            $tmp_data1[] = [
                'x' => $post_date,
                'y' => $tmp_pct1
            ];

            $tmp_data2[] = [
                'x' => $post_date,
                'y' => $tmp_pct2
            ];

            $tmp_data3[] = [
                'x' => $post_date,
                'y' => $tmp_pct3
            ];

            $tmp_data4[] = [
                'x' => $post_date,
                'y' => $tmp_pct4
            ];
        }

        $data2 = [
            [
                'name' => $status_arr[1]['label'],
                'data' => $tmp_data1,
                'color' => $status_arr[1]['color']
            ],
            [
                'name' => $status_arr[2]['label'],
                'data' => $tmp_data2,
                'color' => $status_arr[2]['color']
            ],
            [
                'name' => $status_arr[3]['label'],
                'data' => $tmp_data3,
                'color' => $status_arr[3]['color']
            ],
            [
                'name' => $status_arr[4]['label'],
                'data' => $tmp_data4,
                'color' => $status_arr[4]['color']
            ],
        ];

        return $this->render('monthly-stock-take', [
            'model' => $model,
            'data' => $data,
            'data2' => $data2,
            'drilldown' => $drilldown,
            'period_dropdown_arr' => $period_dropdown_arr,
        ]);
    }

	public function actionStockTakingProgress($value='')
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $tmp_data = $tmp_data_open = $tmp_data_close = $data = [];
        $this_period = date('Ym');

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');

        $period_dropdown_arr = ArrayHelper::map(PcPiVariance::find()->select('period')->groupBy('period')->orderBy('period DESC')->all(), 'period', 'period');
        if (!isset($period_dropdown_arr[$this_period])) {
        	$period_dropdown_arr[$this_period] = $this_period;
        	krsort($period_dropdown_arr);
        }

        $categories_arr = [];
        if ($model->load($_GET)) {
            if ($model->period == $this_period) {
                $tmp_total = StoreOnhandWsus::find()->where(['MAT_CLASS' => '9040'])->andWhere('category IS NOT NULL')->count();
                $tmp_variance = StoreOnhandWsus::find()->select([
                    'category',
                    'total_open' => 'COUNT(*)',
                    'total_close' => 'SUM(CASE WHEN dandory_date IS NOT NULL THEN 1 ELSE 0 END)'
                ])
                ->where(['MAT_CLASS' => '9040'])
                ->andWhere('category IS NOT NULL')
                ->groupBy('category')
                ->all();

                $total_pct_open = $total_pct_close = 0;
                foreach ($tmp_variance as $key => $value) {
                    $pct_open = $pct_close = 0;
                    if ($tmp_total > 0) {
                        $pct_open = round(($value->total_open / $tmp_total) * 100, 0);
                        $pct_close = round(($value->total_close / $tmp_total) * 100, 0);
                    }

                    $total_pct_open += $pct_open;
                    $total_pct_close += $pct_close;
                    if (!in_array($value->category, $categories_arr)) {
                        $categories_arr[] = $value->category;
                    }

                    $tmp_data_close[] = $pct_close;

                    $tmp_data_open[] = $pct_open;
                }
            } else {
                $tmp_total = PcPiVariance::find()
                ->where('category IS NOT NULL')
                ->andWhere([
                    'period' => $model->period
                ])
                ->count();

                $tmp_variance = PcPiVariance::find()
                ->select([
                    'category',
                    'total_open' => 'COUNT(*)',
                    'total_close' => 'SUM(CASE WHEN dandory_date IS NOT NULL THEN 1 ELSE 0 END)'
                ])
                ->where('category IS NOT NULL')
                ->andWhere([
                    'period' => $model->period
                ])
                ->groupBy('category')
                ->orderBy('category')
                ->all();

                $total_pct_open = $total_pct_close = 0;
                foreach ($tmp_variance as $key => $value) {
                    $pct_open = $pct_close = 0;
                    if ($tmp_total > 0) {
                        $pct_open = round(($value->total_open / $tmp_total) * 100, 0);
                        $pct_close = round(($value->total_close / $tmp_total) * 100, 0);
                    }

                    $total_pct_open += $pct_open;
                    $total_pct_close += $pct_close;
                    if (!in_array($value->category, $categories_arr)) {
                        $categories_arr[] = $value->category;
                    }

                    $tmp_data_close[] = $pct_close;

                    $tmp_data_open[] = $pct_open;
                }
            }

            $tmp_data_open[] = [
                'isSum' => true,
            ];

            $tmp_data_close[] = [
                'isSum' => true,
            ];

            $categories_arr[] = 'Total';
        	
        	$data = [
        		[
                    'name' => 'PLAN',
        			'data' => $tmp_data_open,
        			'dataLabels' => [
        				'enabled' => true,
        				'formatter' => new JsExpression('function(){ return this.y + "%"; }'),
        			],
        		],
                [
                    'name' => 'ACTUAL',
                    'data' => $tmp_data_close,
                    'dataLabels' => [
                        'enabled' => true,
                        'formatter' => new JsExpression('function(){ return this.y + "%"; }'),
                    ],
                ],
        	];

            $data2 = [
                [
                    'name' => 'PLAN',
                    'data' => [
                        [
                            'x' => (strtotime('2020-09-01' . " +7 hours") * 1000),
                            'y' => 5,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ],
                        [
                            'x' => (strtotime('2020-09-05' . " +7 hours") * 1000),
                            'y' => 10,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ],
                        [
                            'x' => (strtotime('2020-09-10' . " +7 hours") * 1000),
                            'y' => 15,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ]
                    ],
                ],
                [
                    'name' => 'ACTUAL',
                    'data' => [
                        [
                            'x' => (strtotime('2020-09-01' . " +7 hours") * 1000),
                            'y' => 5,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ],
                        [
                            'x' => (strtotime('2020-09-05' . " +7 hours") * 1000),
                            'y' => 5,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ],
                        [
                            'x' => (strtotime('2020-09-10' . " +7 hours") * 1000),
                            'y' => 5,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ]
                    ],
                ],
            ];
        }

        return $this->render('stock-taking-progress', [
        	'model' => $model,
            'categories_arr' => $categories_arr,
        	'data' => $data,
            'data2' => $data2,
        	'period_dropdown_arr' => $period_dropdown_arr,
        ]);
	}
}