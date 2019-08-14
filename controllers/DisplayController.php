<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
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
use app\models\MachineIotCurrentEffPershiftLog;

//go machine order
use app\models\GojekOrderView01;

use app\models\SernoOutput;

use app\models\MachineIot;
use app\models\MachineIotCurrent;
use app\models\GojekTbl;
use app\models\PcbNgDaily;
use app\models\MasalahPcb;
use app\models\GojekOrderTbl;
use app\models\MachineIotOutput;
use app\models\SernoCalendar;
use app\models\WipHdrDtr;
use app\models\MeetingEvent;
use app\models\MrbsRoom;

class DisplayController extends Controller
{
    public function actionTodaysMeetingData($room_id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        if ($room_id == 9) {
            $meeting_content = '<span style="font-size: 10em; color: rgba(255, 235, 59, 1)">NO GUEST TODAY</span>';
        } else {
            $meeting_content = '<span style="font-size: 10em; color: rgba(255, 235, 59, 1)">NO MEETING TODAY</span>';
        }
        $room_info = MrbsRoom::find()
        ->where(['id' => (int)$room_id])
        ->one();

        $room_name = strtoupper($room_info->room_name);
        if ($room_id == 1 || $room_id == 6) {
            $room_name = strtoupper($room_info->room_name . ' ROOM');
        }

        $tmp_data = MeetingEvent::find()
        ->where([
            'room_id' => $room_id,
            'tgl_start' => $today
        ])
        ->orderBy('jam_start')
        ->all();

        if (count($tmp_data) > 0) {
            $meeting_content = '<table class="table" cellspacing="0" style="">';
            $count = 1;
            foreach ($tmp_data as $key => $value) {
                if ($value->jam_end < date('H:i:s')) {
                    $font_color = 'rgba(255, 235, 59, 0.3)';
                    $opacity = 0.3;
                } else {
                    $font_color = 'rgba(255, 235, 59, 1)';
                    $opacity = 0.9;
                }

                $background_color = 'rgba(255, 255, 255, 0)';
                if (date('H:i:s') > $value->jam_start && date('H:i:s') < $value->jam_end) {
                    $background_color = 'rgba(255, 255, 255, 0.25)';
                }
                $meeting_content .= '<tr style="color: rgba(255, 235, 59, 1); opacity: ' . $opacity . '; background-color: ' . $background_color . ';">
                <td style="border-top: 0px; width: 540px; color: rgba(59, 255, 248, 1); font-size: 5.5em; padding: 12px 0px 0px 20px; letter-spacing: 2px;">(' . substr($value->jam_start, 0, 5) . '-' . substr($value->jam_end, 0, 5) .
                ')</td>
                <td style="border-top: 0px; font-size: 7em;  letter-spacing: 2px;">' . strtoupper($value->name) . '</td></tr>';
            }
            $meeting_content .= '</table>';
        }
        
        $data = [
            'room_name' => $room_name,
            'today' => strtoupper(date('d M\' Y')),
            'meeting_content' => $meeting_content
        ];
        return $data;
    }
    public function actionTodaysMeeting()
    {
        $this->layout = 'clean';
        $today = date('Y-m-d');
        $data = [];
        $room_name = '';

        if (isset($_GET['room_id']) && $_GET['room_id'] != null) {
            $room_info = MrbsRoom::find()
            ->where(['id' => (int)$_GET['room_id']])
            ->one();

            $tmp_data = MeetingEvent::find()
            ->where([
                'room_id' => $_GET['room_id'],
                'tgl_start' => $today
            ])
            ->all();
            //echo $_GET['room_id'];
        }
        
        return $this->render('todays-meeting', [
            'data' => $tmp_data,
            'room_info' => $room_info,
        ]);
    }

    public function actionChourei()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        //$yesterday = date('Y-m-d', strtotime('-1 day'));
        $today = date('Y-m-d');
        //$tomorrow = date('Y-m-d', strtotime('+1 day'));

        $tmp_yesterday = SernoCalendar::find()
        ->select('etd')
        ->where(['<', 'etd', $today])
        ->orderBy('etd DESC')
        ->one();
        //echo $tmp_yesterday->etd;

        $serno_calendar = SernoCalendar::find()
        ->select('etd')
        ->where(['>=', 'etd', $tmp_yesterday->etd])
        ->limit(3)
        ->all();

        $cal_arr = [];
        foreach ($serno_calendar as $key => $value) {
            $cal_arr[] = $value->etd;
        }

        $shipping_data = SernoOutput::find()
        ->joinWith('sernoMaster')
        ->select([
            'etd',
            'model' => 'tb_serno_master.model',
            'qty' => 'SUM(qty)',
            'output' => 'SUM(output)',
            'balance' => 'SUM(output-qty)'
        ])
        ->where(['etd' => $cal_arr])
        ->groupBy('etd, tb_serno_master.model')
        ->orderBy('etd')
        ->all();

        $tmp_shipping_arr = [];
        $model_name = [];
        foreach ($shipping_data as $key => $value) {
            $tmp_shipping_arr[$value->etd]['plan'] += $value->qty;
            $tmp_shipping_arr[$value->etd]['actual'] += $value->output;
            $tmp_shipping_arr[$value->etd]['balance'] += $value->balance;

            if ($value->balance < 0) {
                if (!isset($tmp_shipping_arr[$value->etd]['gmc_balance'][$value->model])) {
                    $gmc_desc = $value->sernoMaster->description;
                    $tmp_shipping_arr[$value->etd]['gmc_balance'][$value->model] = 0;
                    $model_name[$value->model] = $gmc_desc;
                }
                $tmp_shipping_arr[$value->etd]['gmc_balance'][$value->model] += $value->balance;
            }

            //arsort($tmp_shipping_arr[$value->etd]['gmc_balance']);
        }

        foreach ($cal_arr as $key => $value) {
            $plan = $tmp_shipping_arr[$value]['plan'];
            $actual = $tmp_shipping_arr[$value]['actual'];
            if ($plan > 0) {
                $pct = round(($actual / $plan) * 100, 1);
            } else {
                $pct = 0;
            }
            $tmp_shipping_arr[$value]['percentage'] = $pct;

            if (isset($tmp_shipping_arr[$value]['gmc_balance'])) {
                asort($tmp_shipping_arr[$value]['gmc_balance']);
                $tmp_shipping_arr[$value]['gmc_balance'] = array_slice($tmp_shipping_arr[$value]['gmc_balance'], 0, 3);
            }

        }

        //vms
        $wip_hdr_dtr = WipHdrDtr::find()
        ->select([
            'source_date', 'child_analyst', 'child_analyst_desc', 'model_group',
            'plan_total' => 'SUM(act_qty)',
            'output_total' => 'SUM(CASE WHEN stage IN (\'03-COMPLETED\', \'04-HAND OVER\') THEN act_qty ELSE 0 END)',
            'balance_total' => 'SUM(CASE WHEN stage IN (\'00-ORDER\', \'01-CREATED\', \'02-STARTED\') THEN -act_qty ELSE 0 END)'
        ])
        ->where([
            'source_date' => $cal_arr,
            'child_analyst' => ['WP01', 'WW02']
        ])
        ->andWhere('stage IS NOT NULL')
        ->groupBy('source_date, child_analyst, child_analyst_desc, model_group')
        ->orderBy('source_date, child_analyst_desc, balance_total')
        ->asArray()
        ->all();

        $tmp_vms_data = [];
        foreach ($wip_hdr_dtr as $key => $value) {
            $source_date = date('Y-m-d', strtotime($value['source_date']));
            $tmp_vms_data[$value['child_analyst_desc']][$source_date]['plan'] += $value[plan_total];
            $tmp_vms_data[$value['child_analyst_desc']][$source_date]['actual'] += $value[output_total];
            $tmp_vms_data[$value['child_analyst_desc']][$source_date]['balance'] += $value[balance_total];

            if ($value['balance_total'] < 0) {
                $tmp_vms_data[$value['child_analyst_desc']][$source_date]['gmc_balance'][$value['model_group']] = $value['balance_total'];
            }
        }

        foreach ($tmp_vms_data as $child_analyst_desc => $summary_arr) {
            foreach ($summary_arr as $source_date => $value) {
                $tmp_pct = 0;
                $plan = $value['plan'];
                $actual = $value['actual'];
                if ($plan > 0) {
                    $tmp_pct = round(($actual / $plan) * 100, 2);
                }
                $tmp_vms_data[$child_analyst_desc][$source_date]['percentage'] = $tmp_pct;

                if (isset($tmp_vms_data[$child_analyst_desc][$source_date]['gmc_balance'])) {
                    $tmp_vms_data[$child_analyst_desc][$source_date]['gmc_balance'] = array_slice($tmp_vms_data[$child_analyst_desc][$source_date]['gmc_balance'], 0, 3);
                }
            }
        }

        return $this->render('chourei', [
            'shipping_data' => $tmp_shipping_arr,
            'cal_arr' => $cal_arr,
            'vms_data' => $tmp_vms_data,
        ]);
    }

    public function getMinutes($start, $end)
    {
        $start_date = new \DateTime($start);
        $since_start = $start_date->diff(new \DateTime($end));
        $minutes = $since_start->days * 24 * 60;
        $minutes += $since_start->h * 60;
        $minutes += $since_start->i;
        return $minutes;
    }

    public function isBreakTime($datetime)
    {
        date_default_timezone_set('Asia/Jakarta');

        $datetime = new \DateTime($datetime);

        $break_time1 = new \DateTime(date('Y-m-d 09:20:00'));
        $break_time1_end = new \DateTime(date('Y-m-d 09:30:00'));
        $break_time2 = new \DateTime(date('Y-m-d 12:10:00'));
        $break_time2_end = new \DateTime(date('Y-m-d 12:50:00'));
        $break_time3 = new \DateTime(date('Y-m-d 14:20:00'));
        $break_time3_end = new \DateTime(date('Y-m-d 14:30:00'));

        if ($today_name == 'Fri') {
            $break_time2 = new \DateTime(date('Y-m-d 12:00:00'));
            $break_time2_end = new \DateTime(date('Y-m-d 13:10:00'));
            $break_time3 = new \DateTime(date('Y-m-d 14:50:00'));
            $break_time3_end = new \DateTime(date('Y-m-d 15:00:00'));
        }

        if ($datetime > $break_time1 && $datetime < $break_time1_end) {
            return true;
        }

        if ($datetime > $break_time2 && $datetime < $break_time2_end) {
            return true;
        }

        if ($datetime > $break_time3 && $datetime < $break_time3_end) {
            return true;
        }

        return false;
    }

    public function actionGoSubDriverStatusData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        //$now = '2019-08-14 09:25:00';
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tmp_data = GojekTbl::find()->where(['SOURCE' => 'SUB'])->orderBy('GOJEK_DESC')->asArray()->all();
        $tmp_order = GojekOrderTbl::find()
        ->where([
            'source' => 'SUB',
            'STAT' => 'O'
        ])
        ->andWhere('daparture_date IS NULL')
        ->asArray()
        ->all();
        $tmp_str = '';
        $tmp_str .= '<div class="row">';
        foreach ($tmp_data as $key => $value) {
            $get_new_order = false;
            $txt_new_order = '';
            foreach ($tmp_order as $key => $value_order) {
                if ($value_order['GOJEK_ID'] == $value['GOJEK_ID']) {
                    $get_new_order = true;
                }
            }

            if ($value['HADIR'] == 'N') {
                $bg_class = ' bg-gray';
                $text_remark = 'INACTIVE';
            } else {
                if ($value['STAGE'] == 'STANDBY') {
                    $bg_class = ' bg-red';
                    $text_remark = 'STANDBY';
                } elseif ($value['STAGE'] == 'DEPARTURE') {
                    $bg_class = ' bg-green';
                    $text_remark = 'START WORKING - ' . date('H:i', strtotime($value['LAST_UPDATE'])) . '';
                } elseif ($value['STAGE'] == 'ARRIVAL') {
                    $bg_class = ' bg-yellow';
                    $text_remark = 'JUST FINISHED - ' . date('H:i', strtotime($value['LAST_UPDATE'])) . '';
                    $diff_min = $this->getMinutes($value['LAST_UPDATE'], date('Y-m-d H:i:s'));
                    if ($diff_min > 2) {
                        if ($value['LAST_UPDATE'] == date('Y-m-d')) {
                            $bg_class = ' bg-light-blue';
                            $text_remark = 'IDLING > 2 MIN [ SINCE - ' . date('H:i', strtotime($value['LAST_UPDATE'])) . ' ]';
                        } else {
                            $bg_class = ' bg-light-blue';
                            $text_remark = 'STANDBY';
                        }
                        if ($get_new_order) {
                            $txt_new_order = '<span class="pull-right label label-default" style="position: absolute; top: 65px; right: 10px;">New Order!</span>';
                        }
                    }
                    
                } else {
                    $bg_class = ' bg-aqua';
                    $text_remark = 'NO INFORMATION';
                }
                if ($this->isBreakTime($now)) {
                    $txt_new_order = '<span class="pull-right label label-default" style="position: absolute; top: 65px; right: 10px;">Break Time!</span>';
                }
                //$txt_new_order = '<span class="pull-right label label-default" style="position: absolute; top: 65px; right: 10px;">Break Time!</span>';
                //$txt_new_order = '<span class="pull-right label label-default" style="position: absolute; top: 65px; right: 10px;">New Order!</span>';
            }
            
            $filename = $value['GOJEK_ID'] . '.jpg';
            $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
            if (file_exists($path)) {
                $profpic =  Html::img('@web/uploads/yemi_employee_img/' . $value['GOJEK_ID'] . '.jpg', [
                    'class' => 'img-circle',
                    'style' => 'object-fit: cover; height: 60px; width: 60px;'
                ]);
            } else {
                $profpic =  Html::img('@web/uploads/profpic_03.png', [
                    'class' => 'img-circle',
                    'style' => 'object-fit: cover; height: 60px; width: 60px;'
                ]);
            }
            
            $tmp_str .= '<div class="col-md-3">
                <div class="box box-widget widget-user-2">
                    <div class="widget-user-header' . $bg_class . '">
                        <div class="widget-user-image">
                            ' . $profpic . '
                        </div>
                        <h3 class="widget-user-username" style="font-size: 18px; font-weight: 500;">' . $value['GOJEK_DESC'] . ' <span style="position: absolute; top: 10px; right: 10px;">[' . $value['GOJEK_ID'] . ']</span>' . $txt_new_order . '</h3>
                        <h5 class="widget-user-desc">' . $text_remark . '</h5>
                    </div>
                </div>
            </div>';
        }
        $tmp_str .= '</div>';
        return $tmp_str;
    }
    public function actionGoSubDriverStatus($value='')
    {
        $this->layout = 'clean';
        $data = [];
        return $this->render('go-sub-driver-status', [
            'data' => $data
        ]);
    }

    public function actionFgsStockDetail($over_category, $days, $category)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>FGS Stock <small>(' . $category . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 14px;">
            <th>Port</th>
            <th class="text-center">GMC</th>
            <th>Description</th>
            <th class="text-center">Qty</th>
        </tr>';

        if ($over_category == 1) {
            $data_arr = SernoInput::find()
            ->joinWith('sernoOutput')
            ->joinWith('sernoMaster')
            ->select([
                'tb_serno_output.dst', 'tb_serno_input.gmc',
                'tb_serno_master.model', 'tb_serno_master.dest', 'tb_serno_master.color',
                'total' => 'COUNT(tb_serno_input.gmc)'
            ])
            ->where([
                'loct' => 2,
                'tb_serno_input.adv' => 0,
            ])
            ->andWhere(['<>', 'loct_time', '0000-00-00'])
            ->andWhere(['>=', 'DATEDIFF(tb_serno_output.etd, CURDATE())', $days])
            ->groupBy('tb_serno_output.dst, tb_serno_input.gmc')
            ->all();
        } else {
            $data_arr = SernoInput::find()
            ->joinWith('sernoOutput')
            ->joinWith('sernoMaster')
            ->select([
                'tb_serno_output.dst', 'tb_serno_input.gmc',
                'tb_serno_master.model', 'tb_serno_master.dest', 'tb_serno_master.color',
                'total' => 'COUNT(tb_serno_input.gmc)'
            ])
            ->where([
                'loct' => 2,
                'tb_serno_input.adv' => 0,
                'DATEDIFF(tb_serno_output.etd, CURDATE())' => $days
            ])
            ->andWhere(['<>', 'loct_time', '0000-00-00'])
            ->groupBy('tb_serno_output.dst, tb_serno_input.gmc')
            ->all();
        }
        

        $no = 1;
        foreach ($data_arr as $key => $value) {
            $remark .= '<tr style="font-size: 14px;">
                <td>' . $value->dst . '</td>
                <td class="text-center">' . $value->gmc . '</td>
                <td>' . $value->partName . '</td>
                <td class="text-center">' . $value->total . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionFgsStock($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $limit_over = 12;

        $tmp_input_arr = SernoInput::find()
        ->joinWith('sernoOutput')
        ->select([
            'days_diff' => 'DATEDIFF(tb_serno_output.etd, CURDATE())',
            'dst' => 'tb_serno_output.dst',
            'total' => 'COUNT(CURDATE())'
        ])
        ->where([
            'loct' => 2,
            'tb_serno_input.adv' => 0
        ])
        ->andWhere(['<>', 'loct_time', '0000-00-00'])
        ->groupBy('DATEDIFF(tb_serno_output.etd, CURDATE()), tb_serno_output.dst')
        ->having('days_diff > -1')
        ->orderBy('DATEDIFF(tb_serno_output.etd, CURDATE()) DESC, tb_serno_output.dst')
        ->all();

        $tmp_data = $tmp_data2 = $tmp_data3 = $categories = [];
        foreach ($tmp_input_arr as $key => $value) {
            $tmp_title = $limit_over;

            if ($value->days_diff < $limit_over) {
                $tmp_title = $value->days_diff;
            }

            if (!isset($tmp_data[$tmp_title])) {
                $tmp_data[$tmp_title] = 0;
            }
            $tmp_data[$tmp_title] += $value->total;

            if (!isset($tmp_data3[$tmp_title][$value->dst])) {
                $tmp_data3[$tmp_title][$value->dst] = 0;
            }
            $tmp_data3[$tmp_title][$value->dst] += $value->total;
        }

        foreach ($tmp_data as $key => $value) {
            $tmp_category = '';
            if ((int)$key == $limit_over) {
                $tmp_category = $key . ' d and over';
                $over_category = 1;
            } elseif((int)$key == 0) {
                $tmp_category = 'Today';
                $over_category = 0;
            } else {
                $tmp_category = $key . ' d';
                $over_category = 0;
            }

            $categories[] = $tmp_category;
            
            $tmp_data2[] = [
                'y' => $value,
                'url' => Url::to(['fgs-stock-detail', 'over_category' => $over_category, 'days' => (int)$key, 'category' => $tmp_category]),
            ];
        }

        $data_table = $table_column = [];
        foreach ($tmp_data3 as $key => $value) {
            arsort($value);
            $table_column[] = $key;
            $data_table[$key] = $value;
        }

        $data[] = [
            'name' => 'FGS Stock',
            'data' => $tmp_data2,
            'showInLegend' => false
        ];

        return $this->render('fgs-stock', [
            'data' => $data,
            'data_table' => $data_table,
            'table_column' => $table_column,
            'categories' => $categories
        ]);
    }
    public function getLineArr()
    {
        $tmp_data = MasalahPcb::find()
        ->where('line_pcb IS NOT NULL')
        ->andWhere(['<>', 'line_pcb', ''])
        ->groupBy('line_pcb')
        ->orderBy('line_pcb')
        ->all();

        $data_arr = [];

        foreach ($tmp_data as $key => $value) {
            $data_arr[$value->line_pcb] = $value->line_pcb;
        }

        return $data_arr;
    }

    public function actionDefectDailyPcbGetRemark($post_date, $line_pcb)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>NG Detail <small>(' . $post_date . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 12px;">
            <th class="text-center">No.</th>
            <th class="text-center">Kode Laporan</th>
            <th class="text-center">GMC</th>
            <th class="text-center">PCB</th>
            <th class="text-center">NG Found</th>
            <th class="text-center">Side</th>
            <th class="text-center">Qty</th>
            <th>Problem</th>
            <th>Cause</th>
        </tr>';

        $data_arr = MasalahPcb::find()
        ->where([
            'date(created_date)' => $post_date,
            'line_pcb' => $line_pcb
        ])
        ->orderBy('created_date')
        ->all();

        $no = 1;
        foreach ($data_arr as $key => $value) {
            $remark .= '<tr style="font-size: 12px;">
                <td class="text-center">' . $no . '</td>
                <td class="text-center">' . $value->kode_laporan_pcb . '</td>
                <td class="text-center">' . $value->kode_gmc . '</td>
                <td class="text-center">' . $value->pcb . '</td>
                <td class="text-center">' . $value->ng_found . '</td>
                <td class="text-center">' . $value->side . '</td>
                <td class="text-center">' . $value->qty_pcb . '</td>
                <td>' . $value->problem_pcb . '</td>
                <td>' . $value->cause_pcb . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionDefectDailyPcb($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [];
        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $model = new \yii\base\DynamicModel([
            'year', 'month', 'line_pcb'
        ]);
        $model->addRule(['year', 'month', 'line_pcb'], 'required');
        if (\Yii::$app->request->get('line') !== null) {
            $model->line_pcb = \Yii::$app->request->get('line');
        }

        $model->month = date('m');
        $model->year = date('Y');
        $pcb_line_arr = $this->getLineArr();
        if ($model->load($_GET) || \Yii::$app->request->get('line') !== null)
        {
            $period = $model->year . $model->month;

            $ng_daily = MasalahPcb::find()
            ->select([
                'post_date' => 'CAST(created_date AS date)',
                'total' => 'COUNT(kode_laporan_pcb)'
            ])
            ->where([
                'EXTRACT(year_month FROM created_date)' => $period,
                'line_pcb' => $model->line_pcb
            ])
            ->groupBy('post_date')
            ->orderBy('post_date')
            ->all();

            foreach ($ng_daily as $key => $value) {
                $post_date = (strtotime($value->post_date . " +7 hours") * 1000);
                $tmp_data[] = [
                    'x' => $post_date,
                    'y' => (int)$value->total,
                    'url' => Url::to(['defect-daily-pcb-get-remark', 'post_date' => $value->post_date, 'line_pcb' => $model->line_pcb]),
                ];
            }

            $data = [
                [
                    'name' => 'Total NG',
                    'data' => $tmp_data,
                    'color' => 'rgba(255, 0, 0, 0.8)'
                ],
            ];
        }

        return $this->render('defect-daily-pcb', [
            'data' => $data,
            'model' => $model,
            'month_arr' => $month_arr,
            'pcb_line_arr' => $pcb_line_arr
        ]);
    }
    public function actionIotTimeline($machine_id = 'MNT00078')
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        $data[] = [
            'name' => 'TEST',
            'data' => [
                [
                    'x' => (int)strtotime('2019-07-01') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
                [
                    'x' => (int)strtotime('2019-07-02') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
                [
                    'x' => (int)strtotime('2019-07-03') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
                [
                    'x' => (int)strtotime('2019-07-04') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
                [
                    'x' => (int)strtotime('2019-07-05') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
            ],
        ];
        return $data;
    }

    public function actionLSeriesDaily()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $categories = $data = $tmp_data = [];

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d') . ' -1 month'));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d') . ' -1 month'));

        $model->load($_GET);

        $tmp_serno_output = SernoOutput::find()
        ->joinWith('sernoMaster')
        ->select([
            'etd', 'dst',
            'vms' => 'MIN(vms)',
            'total_qty' => 'datediff(etd, MIN(vms))'
        ])
        ->where([
            'line' => 'L85'
        ])
        ->andWhere(['>=', 'etd', $model->from_date])
        ->andWhere(['<=', 'etd', $model->to_date])
        ->groupBy('etd, dst')
        ->orderBy('etd, dst')
        ->all();

        foreach ($tmp_serno_output as $key => $value) {
            $total_qty = $value->total_qty;
            if ($total_qty > 0) {
                if ($total_qty > 40) {
                    $total_qty -= 33;
                } elseif ($total_qty > 35) {
                    $total_qty -= 27;
                } elseif ($total_qty > 30) {
                    $total_qty -= 23;
                } elseif ($total_qty > 25) {
                    $total_qty -= 17;
                } elseif ($total_qty > 20) {
                    $total_qty -= 13;
                } elseif ($total_qty > 10) {
                    $total_qty -= 7;
                }
                $categories[] = $value->etd . ' [ ' . $value['dst'] . ' ]';
                $tmp_data[] = [
                    'y' => (int)$total_qty
                ];
            }
            
        }

        $data[] = [
            'name' => 'Production Lead Time L-Series',
            'data' => $tmp_data,
            'showInLegend' => false
        ];

        return $this->render('l-series-daily', [
            'data' => $data,
            'model' => $model,
            'categories' => $categories,
        ]);
    }
    public function actionGoMachineOrderCompletion()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [];
        $categories = [];

        $driver_arr = GojekTbl::find()
        ->where([
            'SOURCE' => 'MCH'
        ])
        ->orderBy('HADIR DESC, GOJEK_DESC')
        ->all();

        $tmp_data = [];

        foreach ($driver_arr as $value) {
            $nik = $value->GOJEK_ID;
            $order_data_arr = GojekOrderView01::find()
            ->select([
                'GOJEK_ID',
                'GOJEK_DESC',
                'request_ymd',
                'stat_open' => 'SUM(CASE WHEN STAT = \'O\' THEN 1 ELSE 0 END)',
                'stat_close' => 'SUM(CASE WHEN STAT = \'C\' THEN 1 ELSE 0 END)',
                'stat_total' => 'COUNT(STAT)'
            ])
            ->where([
                'GOJEK_ID' => $nik,
            ])
            ->andWhere(['>=', 'request_ymd', date('Y-m-d', strtotime(date('Y-m-d') . '-10 days'))])
            ->groupBy('GOJEK_ID, GOJEK_DESC, request_ymd')
            ->orderBy('GOJEK_DESC, request_ymd')
            ->asArray()
            ->all();

            $total_point = 0;
            if (count($order_data_arr) > 0) {
                foreach ($order_data_arr as $order_data) {
                    if ($order_data['request_ymd'] == date('Y-m-d') && $nik == $order_data['GOJEK_ID']) {
                        $total_point = $order_data['stat_close'];
                    }
                    $issued_date = (strtotime($order_data['request_ymd'] . " +7 hours") * 1000);
                    $tmp_data[$nik]['open'][] = [
                        'x' => $issued_date,
                        'y' => $order_data['stat_open'] == 0 ? null : (int)$order_data['stat_open'],
                        'url' => Url::to(['get-remark', 'request_ymd' => $order_data['request_ymd'], 'GOJEK_ID' => $order_data['GOJEK_ID'], 'GOJEK_DESC' => $order_data['GOJEK_DESC'], 'STAT' => 'O']),
                    ];
                    $tmp_data[$nik]['close'][] = [
                        'x' => $issued_date,
                        'y' => $order_data['stat_close'] == 0 ? null : (int)$order_data['stat_close'],
                        'url' => Url::to(['get-remark', 'request_ymd' => $order_data['request_ymd'], 'GOJEK_ID' => $order_data['GOJEK_ID'], 'GOJEK_DESC' => $order_data['GOJEK_DESC'], 'STAT' => 'C']),
                    ];
                    $tmp_data[$nik]['nama'] = $order_data['GOJEK_DESC'];
                }
            } else {
                $tmp_data[$nik]['open'] = null;
                $tmp_data[$nik]['close'] = null;
                $tmp_data[$nik]['nama'] = $value->GOJEK_DESC;
            }
            $tmp_data[$nik]['last_stage'] = $value->STAGE;
            $tmp_data[$nik]['from_loc'] = $value->from_loc;
            $tmp_data[$nik]['to_loc'] = $value->to_loc;
            $tmp_data[$nik]['last_update'] = $value->LAST_UPDATE;
            $tmp_data[$nik]['hadir'] = $value->HADIR;
            $tmp_data[$nik]['todays_point'] = $total_point;
        }

        $fix_data = [];
        foreach ($tmp_data as $key => $value) {
            $fix_data[$key]['data'] = [
                [
                    'name' => 'OPEN',
                    'data' => $value['open'],
                    'color' => 'rgba(255, 0, 0, 0.6)'
                ],
                [
                    'name' => 'CLOSE',
                    'data' => $value['close'],
                    'color' => 'rgba(0, 255, 0, 0.6)'
                ]
            ];
            $fix_data[$key]['nama'] = $value['nama'];
            $fix_data[$key]['last_stage'] = $value['last_stage'];
            $fix_data[$key]['from_loc'] = $value['from_loc'];
            $fix_data[$key]['to_loc'] = $value['to_loc'];
            $fix_data[$key]['last_update'] = $value['last_update'];
            $fix_data[$key]['hadir'] = $value['hadir'];
            //$fix_data[$key]['todays_point'] = isset($driver_point_arr[$key]) ? $driver_point_arr[$key] : 0;
            $fix_data[$key]['todays_point'] =  $value['todays_point'];
        }

        return $this->render('go-machine-order-completion', [
            //'data' => $data,
            'categories' => $categories,
            'max_order' => $max_order,
            'tmp_data' => $tmp_data,
            'fix_data' => $fix_data,
        ]);
    }

    public function getPostingShift($end_date)
    {
        if ($end_date >= date('Y-m-d 07:00:00') && $end_date <= date('Y-m-d 15:59:59')) {
            $return_data['posting_shift'] = date('Y-m-d');
            $return_data['shift'] = 1;
        }
        if ($end_date >= date('Y-m-d 16:00:00') && $end_date <= date('Y-m-d 21:59:59')) {
            $return_data['posting_shift'] = date('Y-m-d');
            $return_data['shift'] = 2;
        }
        if ($end_date <= date('Y-m-d 06:59:59') && $end_date >= date('Y-m-d 00:00:00')) {
            $return_data['posting_shift'] = date('Y-m-d', strtotime('-1 day'));
            $return_data['shift'] = 3;
        }
        if ($end_date >= date('Y-m-d 22:00:00') && $end_date <= date('Y-m-d 23:59:59')) {
            $return_data['posting_shift'] = date('Y-m-d');
            $return_data['shift'] = 3;
        }
        return $return_data;
    }

    public function actionCurrentStatus()
    {
        date_default_timezone_set('Asia/Jakarta');
        $get_posting_shift = $this->getPostingShift(date('Y-m-d H:i:s'));
        $posting_shift = $get_posting_shift['posting_shift'];
        $tmp_data = MachineIotCurrent::find()->orderBy('kelompok, mesin_description')->asArray()->all();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $working_time_arr = MachineIotCurrentEffLog::find()
        ->select([
            'mesin_id', 'shift',
            'hijau' => 'SUM(hijau)'
        ])
        ->where([
            'posting_shift' => $posting_shift
        ])
        ->groupBy('mesin_id, shift')
        ->asArray()
        ->all();

        $qty_arr = MachineIotOutput::find()
        ->select([
            'posting_shift', 'shift', 'mesin_id', 'mesin_description',
            'lot_qty' => 'SUM(lot_qty)'
        ])
        ->where([
            'posting_shift' => $posting_shift
        ])
        ->groupBy('posting_shift, shift, mesin_id, mesin_description')
        ->asArray()
        ->all();

        $current_job_data = MachineIotOutput::find()
        ->where('end_date IS NULL')
        ->asArray()
        ->all();

        $tmp_working_time = [];
        $tmp_qty_arr = [];
        $tmp_gmc_desc = [];
        $tmp_btn_class = [];
        foreach ($tmp_data as $key => $value) {
            $btn_class = 'btn btn-lg btn-block bg-gray';
            $bg_color = \Yii::$app->params['bg-gray'];
            if($value['status_warna'] == 'KUNING'){
                //background_color = 'yellow';
                $btn_class = 'btn btn-lg btn-block bg-yellow';
                $bg_color = \Yii::$app->params['bg-yellow'];
            } else if ($value['status_warna'] == 'HIJAU') {
                $btn_class = 'btn btn-lg btn-block bg-green';
                $bg_color = \Yii::$app->params['bg-green'];
            } else if ($value['status_warna'] == 'BIRU') {
                $btn_class = 'btn btn-lg btn-block bg-blue';
                $bg_color = \Yii::$app->params['bg-blue'];
            } else if ($value['status_warna'] == 'MERAH') {
                $btn_class = 'btn btn-lg btn-block bg-red';
                $bg_color = \Yii::$app->params['bg-red'];
            }
            $tmp_btn_class[$value['mesin_id'] . '_mesin_desc'] = '<button type="button" class="' . $btn_class . '">' . $value['mesin_description'] . ' - ' . $value['mesin_id'] . '</button>';
            for ($i = 1; $i <= 3; $i++) { 
                $working_time_pct = 0;
                foreach ($working_time_arr as $key => $working_time) {
                    if ($value['mesin_id'] == $working_time['mesin_id'] && $working_time['shift'] == $i) {
                        if ($i == 2) {
                            $total_work_time = 5 * 3600;
                        } else {
                            $total_work_time = 8 * 3600;
                        }
                        $working_time_pct = round(($working_time['hijau'] / $total_work_time) * 100);
                    }
                }
                if ($working_time_pct <= 50) {
                    $tmp_working_time[$value['mesin_id'] . '_shift' . $i . '_working_time']['content'] = $working_time_pct == 0 ? '' : '<span class="" style="">' . $working_time_pct . '</span>';
                    $tmp_working_time[$value['mesin_id'] . '_shift' . $i . '_working_time']['parent_class'] = $working_time_pct == 0 ? '' : 'bg-red text-center';
                } else {
                    $tmp_working_time[$value['mesin_id'] . '_shift' . $i . '_working_time']['content'] = $working_time_pct == 0 ? '' : '<span class="" style="">' . $working_time_pct . '</span>';
                    $tmp_working_time[$value['mesin_id'] . '_shift' . $i . '_working_time']['parent_class'] = $working_time_pct == 0 ? '' : 'bg-green text-center';
                }

                $tmp_qty = 0;
                foreach ($qty_arr as $key => $qty) {
                    if ($value['mesin_id'] == $qty['mesin_id'] && $qty['shift'] == $i) {
                        $tmp_qty = $qty['lot_qty'];
                    }
                }
                $tmp_qty_arr[$value['mesin_id'] . '_shift' . $i . '_qty'] = $tmp_qty == 0 ? '' : number_format($tmp_qty);
            }

            $tmp_current_job = '';
            foreach ($current_job_data as $key => $current_job) {
                if ($value['mesin_id'] == $current_job['mesin_id']) {
                    $tmp_current_job = $current_job['gmc'] . ' - ' . $current_job['gmc_desc'];
                }
            }
            $tmp_gmc_desc[$value['mesin_id'] . '_gmc_desc'] = $tmp_current_job;
            
        }
        
        $data = [
            'working_time' => $tmp_working_time,
            'lot_qty' => $tmp_qty_arr,
            'gmc_desc' => $tmp_gmc_desc,
            'btn_class' => $tmp_btn_class
        ];
        return $data;
    }

    public function actionGetMachineStatus($mesin_id = 'MNT00078', $posting_date = '2019-07-03')
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $data_iot_arr = MachineIot::find()
        ->select([
            'mesin_id', 'mesin_description', 'system_date_time', 'status_warna'
        ])
        ->where([
            'mesin_id' => $mesin_id,
            'posting_date' => $posting_date,
            //'jam_no' => 10
        ])
        ->asArray()
        ->all();

        $current_color = '';
        $mesin_description = '';
        foreach ($data_iot_arr as $key => $value2) {
            $proddate = (strtotime($value2['system_date_time'] . " +7 hours") * 1000);
            $current_color = $value2['status_warna'];
            $mesin_description = $value2['mesin_description'];
            $color = 'rgba(0, 0, 0, 1)';
            if ($value2['status_warna'] == 'PUTIH') {
                $color = 'rgba(255, 255, 255, 1)';
            } elseif ($value2['status_warna'] == 'HIJAU') {
                $color = 'rgba(0, 255, 0, 1)';
            } elseif ($value2['status_warna'] == 'KUNING') {
                $color = 'rgba(255, 255, 0, 1)';
            } elseif ($value2['status_warna'] == 'BIRU') {
                $color = 'rgba(0, 0, 255, 1)';
            } elseif ($value2['status_warna'] == 'MERAH') {
                $color = 'rgba(255, 0, 0, 1)';
            }
            $tmp_data[] = [
                'x' => $proddate,
                'y' => 1,
                'color' => $color
            ];
        }

        $data = [
            'title' => $mesin_description,
            'current_color' => $current_color,
            'series' => [
                [
                    'name' => $mesin_description,
                    'data' => $tmp_data
                ]
            ],
        ];
        
        return $data;
    }
    public function actionMachineRealtimeStatus()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';

        $current_arr = MachineIotCurrent::find()->orderBy('kelompok, mesin_description')->asArray()->all();

        foreach ($current_arr as $key => $value) {
            $machine_arr[$value['mesin_id']] = $value['mesin_description'];
        }

        return $this->render('machine-realtime-status', [
            'data' => $data,
            'machine_arr' => $machine_arr,
            'current_arr' => $current_arr,
        ]);
    }
    public function actionContainerLoading()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';

        $model = new \yii\base\DynamicModel([
            'post_date'
        ]);
        $model->addRule(['post_date'], 'required');

        $model->post_date = date('Y-m-d');

        if ($model->load($_GET)) {
            # code...
        }

        $tmp_data = SernoOutput::find()
        ->joinWith('sernoCnt')
        ->select([
            'cntr',
            'dst' => 'tb_serno_output.dst',
            'status' => 'IFNULL(status, 1.5)',
            'start',
            'tgl',
            'line',
            'gate',
            'remark' => 'tb_serno_cnt.remark',
        ])
        ->where([
            'etd' => $model->post_date
        ])
        ->andWhere(['<>', 'back_order', 2])
        ->groupBy('cntr')
        ->orderBy('status, tb_serno_cnt.remark DESC, gate, line')
        ->asArray()
        ->all();

        return $this->render('container-loading', [
            'data' => $data,
            'model' => $model,
            'tmp_data' => $tmp_data
        ]);
    }

    public function actionMachineStatusRange()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        
        $data = [];
        $categories = [];

        $model = new \yii\base\DynamicModel([
            'machine_id', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','machine_id'], 'required');

        if ($model->load($_GET) || \Yii::$app->request->get('posting_date') !== null) {
            $iot_by_hours = MachineIotCurrentEffLog::find()
            ->where([
                'mesin_id' => $model->machine_id,
            ])
            ->andWhere(['>=', 'posting_shift', $model->from_date])
            ->andWhere(['<=', 'posting_shift', $model->to_date])
            ->asArray()
            ->all();

            $avg_arr = MachineIotCurrentEffLog::find()
            ->select([
                'period_shift',
                'hijau' => 'SUM(hijau)',
                'hijau_biru' => 'SUM(hijau_biru)',
                'total' => 'SUM(total)',
            ])
            ->where([
                'mesin_id' => $model->machine_id,
            ])
            ->andWhere(['>=', 'posting_shift', $model->from_date])
            ->groupBy('period_shift')
            ->all();

            $avg_arr_data = [];
            foreach ($avg_arr as $key => $value) {
                $pct = 0;
                if ($value->hijau_biru > 0) {
                    $pct = round(($value->hijau / $value->hijau_biru) * 100);
                }
                $avg_arr_data[$value->period_shift] = $pct;
            }

            $begin = new \DateTime($model->from_date);
            $end   = new \DateTime(date('Y-m-d', strtotime($model->to_date . ' +1 day')));

            $tmp_data_by_hours = [];
            $tmp_avg_hijau = [];

            foreach ($iot_by_hours as $key => $value) {
                $jam = str_pad($value['jam'], 2, '0', STR_PAD_LEFT);
                $his = $jam . ':00:00';
                $ymd_his = date('Y-m-d', strtotime($value['posting_date'])) . ' ' . $his;
                $proddate = (strtotime($ymd_his . " +7 hours") * 1000);

                $avg_hijau_pct = $avg_arr_data[date('Ym', strtotime($value['posting_date']))];

                $total_putih = round($value['putih'] / 60, 1);
                $total_biru = round($value['biru'] / 60, 1);
                $total_kuning = round($value['kuning'] / 60, 1);
                $total_hijau = round($value['hijau'] / 60, 1);
                $total_merah = round($value['merah'] / 60, 1);
                $total_lost = round($value['lost_data'] / 60, 1);

                $tmp_data_by_hours['merah'][] = [
                    'x' => $proddate,
                    'y' => $total_merah == 0 ? null : $total_merah
                ];
                $tmp_data_by_hours['putih'][] = [
                    'x' => $proddate,
                    'y' => $total_putih == 0 ? null : $total_putih
                ];
                $tmp_data_by_hours['biru'][] = [
                    'x' => $proddate,
                    'y' => $total_biru == 0 ? null : $total_biru
                ];
                $tmp_data_by_hours['kuning'][] = [
                    'x' => $proddate,
                    'y' => $total_kuning == 0 ? null : $total_kuning
                ];
                $tmp_data_by_hours['hijau'][] = [
                    'x' => $proddate,
                    'y' => $total_hijau == 0 ? null : $total_hijau
                ];
                $tmp_data_by_hours['lost'][] = [
                    'x' => $proddate,
                    'y' => $total_lost == 0 ? null : $total_lost
                ];
                $tmp_avg_hijau[] = [
                    'x' => $proddate,
                    'y' => $avg_hijau_pct
                ];
                
            }

            $data_iot_by_hours = [
                [
                    'name' => 'UNKNOWN',
                    'data' => $tmp_data_by_hours['lost'],
                    'color' => 'rgba(0, 0, 0, 0)',
                    'dataLabels' => [
                        'enabled' => false
                    ],
                    'showInLegend' => false,
                    'type' => 'column'
                ],
                [
                    'name' => 'IDLE',
                    'data' => $tmp_data_by_hours['putih'],
                    'color' => 'silver',
                    'type' => 'column'
                ],
                [
                    'name' => 'STOP',
                    'data' => $tmp_data_by_hours['merah'],
                    'color' => 'red',
                    'type' => 'column'
                ],
                [
                    'name' => 'HANDLING',
                    'data' => $tmp_data_by_hours['kuning'],
                    'color' => 'yellow',
                    'type' => 'column'
                ],
                [
                    'name' => 'SETTING',
                    'data' => $tmp_data_by_hours['biru'],
                    'color' => 'blue',
                    'type' => 'column'
                ],
                [
                    'name' => 'RUNNING',
                    'data' => $tmp_data_by_hours['hijau'],
                    'color' => 'green',
                    'type' => 'column'
                ],
                [
                    'name' => 'RUNNING [ AVG ]',
                    'data' => $tmp_avg_hijau,
                    'color' => 'rgba(0, 255, 10, 0.8)',
                    'type' => 'line',
                    'marker' => [
                        'enabled' => false
                    ],
                    'tooltip' => [
                        'valueSuffix' => '%'
                    ],
                ],
            ];

            $machine_iot_util = MachineIotCurrentEffLog::find()
            ->select([
                'posting_shift',
                'merah' => 'SUM(merah)',
                'kuning' => 'SUM(kuning)',
                'hijau' => 'SUM(hijau)',
                'biru' => 'SUM(biru)',
                'putih' => 'SUM(putih)',
                'lost_data' => 'SUM(lost_data)'
            ])
            ->where([
                'mesin_id' => $model->machine_id,
            ])
            ->andWhere(['>=', 'posting_shift', $model->from_date])
            ->andWhere(['<=', 'posting_shift', $model->to_date])
            ->groupBy('posting_shift')
            ->orderBy('posting_shift')
            ->asArray()
            ->all();

            $start_date = (strtotime($model->from_date . " +7 hours") * 1000);
            $end_date = (strtotime($model->to_date . " +7 hours") * 1000);

            $tmp_data = [];
            foreach ($machine_iot_util as $key => $value) {
                $proddate = (strtotime($value['posting_shift'] . " +7 hours") * 1000);
                $total_putih = round($value['putih'] / 60, 1);
                $total_biru = round(($value['biru']) / 60, 1);
                $total_kuning = round(($value['kuning']) / 60, 1);
                $total_hijau = round($value['hijau'] / 60, 1);
                $total_merah = round($value['merah'] / 60, 1);
                $total_sisa = round($value['lost_data'] / 60, 1);

                $tmp_data['PUTIH'][] = [
                    'x' => $proddate,
                    'y' => $total_putih == 0 ? null : $total_putih
                ];
                $tmp_data['BIRU'][] = [
                    'x' => $proddate,
                    'y' => $total_biru == 0 ? null : $total_biru
                ];
                $tmp_data['KUNING'][] = [
                    'x' => $proddate,
                    'y' => $total_kuning == 0 ? null : $total_kuning
                ];
                $tmp_data['HIJAU'][] = [
                    'x' => $proddate,
                    'y' => $total_hijau == 0 ? null : $total_hijau
                ];
                $tmp_data['MERAH'][] = [
                    'x' => $proddate,
                    'y' => $total_merah == 0 ? null : $total_merah
                ];
                $tmp_data['sisa'][] = [
                    'x' => $proddate,
                    'y' => $total_sisa == 0 ? null : $total_sisa
                ];
            }

            $data_iot = [];
            $data_iot = [
                [
                    'name' => 'UNKNOWN',
                    'data' => $tmp_data['sisa'],
                    'color' => 'rgba(0, 0, 0, 0)',
                    'dataLabels' => [
                        'enabled' => false
                    ],
                    'showInLegend' => false,
                ],
                [
                    'name' => 'IDLE',
                    'data' => $tmp_data['PUTIH'],
                    'color' => 'silver'
                ],
                [
                    'name' => 'STOP',
                    'data' => $tmp_data['MERAH'],
                    'color' => 'red'
                ],
                [
                    'name' => 'HANDLING',
                    'data' => $tmp_data['KUNING'],
                    'color' => 'yellow'
                ],
                [
                    'name' => 'SETTING',
                    'data' => $tmp_data['BIRU'],
                    'color' => 'blue'
                ],
                [
                    'name' => 'RUNNING',
                    'data' => $tmp_data['HIJAU'],
                    'color' => 'green',
                ],
                
            ];
        }

        return $this->render('machine-status-range', [
            'model' => $model,
            'posting_date' => $posting_date,
            'machine_id' => $machine_id,
            'categories' => $categories,
            'data_iot' => $data_iot,
            'data_iot_by_hours' => $data_iot_by_hours,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }

    public function actionMachineStatusRangeShift()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        
        $data = [];
        $categories = [];

        $model = new \yii\base\DynamicModel([
            'machine_id', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','machine_id'], 'required');

        if ($model->load($_GET) || \Yii::$app->request->get('posting_date') !== null) {
            $iot_by_hours = MachineIotCurrentEffLog::find()
            ->where([
                'mesin_id' => $model->machine_id,
            ])
            ->andWhere(['>=', 'posting_shift', $model->from_date])
            ->andWhere(['<=', 'posting_shift', $model->to_date])
            ->asArray()
            ->all();

            $avg_arr = MachineIotCurrentEffLog::find()
            ->select([
                'period_shift',
                'hijau' => 'SUM(hijau)',
                'hijau_biru' => 'SUM(hijau_biru)',
                'total' => 'SUM(total)',
            ])
            ->where([
                'mesin_id' => $model->machine_id,
            ])
            ->andWhere(['>=', 'posting_shift', $model->from_date])
            ->groupBy('period_shift')
            ->all();

            $avg_arr_data = [];
            foreach ($avg_arr as $key => $value) {
                $pct = 0;
                if ($value->hijau_biru > 0) {
                    $pct = round(($value->hijau / $value->hijau_biru) * 100);
                }
                $avg_arr_data[$value->period_shift] = $pct;
            }

            $begin = new \DateTime($model->from_date);
            $end   = new \DateTime(date('Y-m-d', strtotime($model->to_date . ' +1 day')));

            $tmp_data_by_hours = [];
            $tmp_avg_hijau = [];

            foreach ($iot_by_hours as $key => $value) {
                $jam = str_pad($value['jam'], 2, '0', STR_PAD_LEFT);
                $his = $jam . ':00:00';
                $ymd_his = date('Y-m-d', strtotime($value['posting_date'])) . ' ' . $his;
                $proddate = (strtotime($ymd_his . " +7 hours") * 1000);

                $avg_hijau_pct = $avg_arr_data[date('Ym', strtotime($value['posting_date']))];

                $total_putih = round($value['putih'] / 60, 1);
                $total_biru = round($value['biru'] / 60, 1);
                $total_hijau = round($value['hijau'] / 60, 1);
                $total_merah = round($value['merah'] / 60, 1);
                $total_lost = round($value['lost_data'] / 60, 1);

                $tmp_data_by_hours['merah'][] = [
                    'x' => $proddate,
                    'y' => $total_merah == 0 ? null : $total_merah
                ];
                $tmp_data_by_hours['putih'][] = [
                    'x' => $proddate,
                    'y' => $total_putih == 0 ? null : $total_putih
                ];
                $tmp_data_by_hours['biru'][] = [
                    'x' => $proddate,
                    'y' => $total_biru == 0 ? null : $total_biru
                ];
                $tmp_data_by_hours['hijau'][] = [
                    'x' => $proddate,
                    'y' => $total_hijau == 0 ? null : $total_hijau
                ];
                $tmp_data_by_hours['lost'][] = [
                    'x' => $proddate,
                    'y' => $total_lost == 0 ? null : $total_lost
                ];
                $tmp_avg_hijau[] = [
                    'x' => $proddate,
                    'y' => $avg_hijau_pct
                ];
                
            }

            $data_iot_by_hours = [
                [
                    'name' => 'UNKNOWN',
                    'data' => $tmp_data_by_hours['lost'],
                    'color' => 'rgba(0, 0, 0, 0)',
                    'dataLabels' => [
                        'enabled' => false
                    ],
                    'showInLegend' => false,
                    'type' => 'column'
                ],
                [
                    'name' => 'IDLE',
                    'data' => $tmp_data_by_hours['putih'],
                    'color' => 'silver',
                    'type' => 'column'
                ],
                [
                    'name' => 'STOP',
                    'data' => $tmp_data_by_hours['merah'],
                    'color' => 'red',
                    'type' => 'column'
                ],
                [
                    'name' => 'SETTING',
                    'data' => $tmp_data_by_hours['biru'],
                    'color' => 'blue',
                    'type' => 'column'
                ],
                [
                    'name' => 'RUNNING',
                    'data' => $tmp_data_by_hours['hijau'],
                    'color' => 'green',
                    'type' => 'column'
                ],
                [
                    'name' => 'RUNNING [ AVG ]',
                    'data' => $tmp_avg_hijau,
                    'color' => 'rgba(0, 255, 10, 0.8)',
                    'type' => 'line',
                    'marker' => [
                        'enabled' => false
                    ],
                    'tooltip' => [
                        'valueSuffix' => '%'
                    ],
                ],
            ];

            $begin = new \DateTime($model->from_date);
            $end = new \DateTime($model->to_date);

            $machine_iot_util = MachineIotCurrentEffPershiftLog::find()
            ->select([
                'posting_shift', 'shift',
                'merah' => 'SUM(merah)',
                'kuning' => 'SUM(kuning)',
                'hijau' => 'SUM(hijau)',
                'biru' => 'SUM(biru)',
                'putih' => 'SUM(putih)',
                'lost_data' => 'SUM(lost_data)'
            ])
            ->where([
                'mesin_id' => $model->machine_id,
            ])
            ->andWhere(['>=', 'posting_shift', $model->from_date])
            ->andWhere(['<=', 'posting_shift', $model->to_date])
            ->groupBy('posting_shift, shift')
            ->asArray()
            ->all();

            $start_date = (strtotime($model->from_date . " +7 hours") * 1000);
            $end_date = (strtotime($model->to_date . " +7 hours") * 1000);
            $tmp_data = $tmp_data2 = [];
            $categories = [];
            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                //$proddate = (strtotime($i->format("Y-m-d") . " +7 hours") * 1000);
                
                for ($j=1; $j <= 3; $j++) { 
                    $categories[] = $i->format("Y-m-d") . ' [' . $j . ']';
                    $total_putih = 0;
                    $total_biru = 0;
                    $total_hijau = 0;
                    $total_merah = 0;
                    $total_sisa = 0;
                    foreach ($machine_iot_util as $key => $value) {
                        if (date('Y-m-d', strtotime($value['posting_shift'])) == $i->format("Y-m-d") && $value['shift'] == $j) {
                            $total_putih = round($value['putih'] / 60, 1);
                            $total_biru = round(($value['biru'] + $value['kuning']) / 60, 1);
                            $total_hijau = round($value['hijau'] / 60, 1);
                            $total_merah = round($value['merah'] / 60, 1);
                            $total_sisa = round($value['lost_data'] / 60, 1);
                            break;
                        }
                    }
                    $tmp_data['PUTIH'][] = [
                        'y' => $total_putih == 0 ? null : $total_putih
                    ];
                    $tmp_data['BIRU'][] = [
                        'y' => $total_biru == 0 ? null : $total_biru
                    ];
                    $tmp_data['HIJAU'][] = [
                        'y' => $total_hijau == 0 ? null : $total_hijau
                    ];
                    $tmp_data['MERAH'][] = [
                        'y' => $total_merah == 0 ? null : $total_merah
                    ];
                    $tmp_data['sisa'][] = [
                        'y' => $total_sisa == 0 ? null : $total_sisa
                    ];
                }
            }

            /*foreach ($machine_iot_util as $key => $value) {
                $proddate = (strtotime($value['posting_shift'] . " +7 hours") * 1000);
                $total_putih = round($value['putih'] / 60, 1);
                $total_biru = round(($value['biru'] + $value['kuning']) / 60, 1);
                $total_hijau = round($value['hijau'] / 60, 1);
                $total_merah = round($value['merah'] / 60, 1);
                $total_sisa = round($value['lost_data'] / 60, 1);

                $tmp_data['PUTIH'][] = [
                    'x' => $proddate,
                    'y' => $total_putih == 0 ? null : $total_putih
                ];
                $tmp_data['BIRU'][] = [
                    'x' => $proddate,
                    'y' => $total_biru == 0 ? null : $total_biru
                ];
                $tmp_data['HIJAU'][] = [
                    'x' => $proddate,
                    'y' => $total_hijau == 0 ? null : $total_hijau
                ];
                $tmp_data['MERAH'][] = [
                    'x' => $proddate,
                    'y' => $total_merah == 0 ? null : $total_merah
                ];
                $tmp_data['sisa'][] = [
                    'x' => $proddate,
                    'y' => $total_sisa == 0 ? null : $total_sisa
                ];
            }*/

            
            $data_iot = [
                [
                    'name' => 'UNKNOWN',
                    'data' => $tmp_data['sisa'],
                    'color' => 'rgba(0, 0, 0, 0)',
                    'dataLabels' => [
                        'enabled' => false
                    ],
                    'showInLegend' => false,
                ],
                [
                    'name' => 'IDLE',
                    'data' => $tmp_data['PUTIH'],
                    'color' => 'silver'
                ],
                [
                    'name' => 'STOP',
                    'data' => $tmp_data['MERAH'],
                    'color' => 'red'
                ],
                [
                    'name' => 'SETTING',
                    'data' => $tmp_data['BIRU'],
                    'color' => 'blue'
                ],
                [
                    'name' => 'RUNNING',
                    'data' => $tmp_data['HIJAU'],
                    'color' => 'green',
                ],
                
            ];
        }

        return $this->render('machine-status-range-shift', [
            'model' => $model,
            'posting_date' => $posting_date,
            'machine_id' => $machine_id,
            'categories' => $categories,
            'data_iot' => $data_iot,
            'data_iot_by_hours' => $data_iot_by_hours,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'categories' => $categories,
        ]);
    }

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

    public function actionMonthlyOvertimeBySectionGetRemark($nik, $nama_karyawan, $period)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $nama_karyawan . ' <small>(' . $period . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 14px;">
            <th class="text-center">Date</th>
            <th class="text-center">Check In</th>
            <th class="text-center">Check Out</th>
            <th class="text-center">Total Hour</th>
            <th>Job Desc.</th>
        </tr>';

        $overtime_data_arr = SplView::find()
        ->where([
            'NIK' => $nik,
            'PERIOD' => $period,
        ])
        ->orderBy('TGL_LEMBUR')
        ->all();

        $no = 1;
        foreach ($overtime_data_arr as $key => $value) {

            $remark .= '<tr style="font-size: 14px;">
                <td class="text-center">' . date('Y-m-d', strtotime($value->TGL_LEMBUR)) . '</td>
                <td class="text-center">' . date('H:i', strtotime($value->START_LEMBUR_ACTUAL)) . '</td>
                <td class="text-center">' . date('H:i', strtotime($value->END_LEMBUR_ACTUAL)) . '</td>
                <td class="text-center">' . $value->NILAI_LEMBUR_ACTUAL . '</td>
                <td>' . $value->KETERANGAN . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

	public function actionMonthlyOvertimeBySection()
	{
		$this->layout = 'clean';
		$model = new \yii\base\DynamicModel([
            'section', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','section'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d') . '-1 year'));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

		if (\Yii::$app->request->get('id') == 'fa') {
			$model->section = '320';
		} elseif (\Yii::$app->request->get('id') == 'pnt') {
			$model->section = '330';
		} elseif (\Yii::$app->request->get('id') == 'ww') {
			$model->section = '300';
		}

		$section_arr = ArrayHelper::map(CostCenter::find()->select('CC_ID, CC_DESC')->groupBy('CC_ID, CC_DESC')->orderBy('CC_DESC')->all(), 'CC_ID', 'CC_DESC');
		$section_arr['ALL'] = '-- ALL SECTIONS --';
		//asort($section_arr);

		if ($model->load($_GET) || \Yii::$app->request->get('id')) {
            $section = $model->section;
            $tmp_categories = SplView::find()
            ->select('PERIOD')
            ->where(['>=', 'PERIOD', date('Ym', strtotime($model->from_date))])
            ->andWhere(['<=', 'PERIOD', date('Ym', strtotime($model->to_date))])
            ->groupBy('PERIOD')
            ->all();
            
            foreach ($tmp_categories as $key => $value) {
                $categories[] = $value->PERIOD;
            }
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
                        'url' => Url::to(['monthly-overtime-by-section-get-remark', 'nik' => $karyawan['NIK'], 'nama_karyawan' => $karyawan['NAMA_KARYAWAN'], 'period' => $period_value])
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
        }

        return $this->render('monthly-overtime-by-section', [
            'data' => $data,
            'model' => $model,
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