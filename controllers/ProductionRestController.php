<?php
namespace app\controllers;

use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use app\models\SernoInput;
use app\models\SernoInputAll;
use app\models\ProdNgData;
use app\models\ProdNgRatio;
use app\models\SernoInputPlan;
use app\models\SernoOutput;
use app\models\DailyProductionOutput;
use app\models\IjazahPlanActual;
use app\models\FiscalTbl;
use app\models\SernoMaster;
use app\models\IjazahProgress;
use app\models\VmsPlanActual;
use app\models\SunfishViewEmp;
use app\models\LiveCookingMember;
use app\models\VmsItem;
use app\models\WorkDayTbl;
use app\models\BentolKaryawan;
use app\models\BentolManagerTripSummary;
use app\models\SapItemTbl;
use app\models\SunfishAttendanceData;
use app\models\CarParkAttendance;
use app\models\RfidCarScan;
use app\models\IjazahItem;
use app\models\PermitInputData;
use app\models\ShippingPeriod;
use app\models\KlinikInput;
use app\models\StoreInOutWsus;
use app\models\MachineIotSingle;
use app\models\MachineIotCurrentMnt;
use app\models\DrsView03;
use app\models\ScanTemperature;
use app\models\InjMachineTbl;
use app\models\InjMoldingTbl;
use app\models\InjMachineMoldingLog;
use app\models\SoPeriodPlanActual;
use app\models\SunfishWorkingTime;
use app\models\SunfishWorkingTimeDaily;
use app\models\ClinicDailyVisitBySection;
use app\models\EmpPermitTbl;

class ProductionRestController extends Controller
{
    public function actionBreakTimeCountDown()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        $now = new \DateTime($this_time);
        $today_name = strtoupper($now->format('D'));

        $break_time_arr = [
            1 => [
                'start' => date('Y-m-d 09:30:00'),
                'end' => date('Y-m-d 09:40:00'),
            ],
            2 => [
                'start' => date('Y-m-d 12:15:00'),
                'end' => date('Y-m-d 12:55:00'),
            ],
            3 => [
                'start' => date('Y-m-d 14:30:00'),
                'end' => date('Y-m-d 14:40:00'),
            ],
        ];

        if ($today_name == 'FRI') {
            $break_time_arr = [
                1 => [
                    'start' => date('Y-m-d 09:30:00'),
                    'end' => date('Y-m-d 09:40:00'),
                ],
                2 => [
                    'start' => date('Y-m-d 12:15:00'),
                    'end' => date('Y-m-d 13:25:00'),
                ],
                3 => [
                    'start' => date('Y-m-d 14:50:00'),
                    'end' => date('Y-m-d 15:00:00'),
                ],
            ];
        }

        $data = [
            'breaktime' => 0,
            'server_time' => date('H:i:s', strtotime($this_time)),
            'start_time' => null,
            'end_time' => null,
            'countdown' => null,
        ];

        foreach ($break_time_arr as $key => $value) {
            $start_time = $value['start'];
            $end_time = $value['end'];
            if (strtotime($this_time) >= strtotime($start_time) && strtotime($this_time) <= strtotime($end_time)) {
                $data['breaktime'] = 1;
                $data['start_time'] = date('H:i', strtotime($start_time));
                $data['end_time'] = date('H:i', strtotime($end_time));
                $datetime1 = $now;
                $datetime2 = new \DateTime($value['end']);
                $interval = $datetime1->diff($datetime2);
                $data['countdown'] = $interval->format('%I:%S');
            }
        }

        return $data;
    }

    public function actionSendEmpPermitOutstanding()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');

        $tmp_today = WorkDayTbl::find()
        ->where([
            'FORMAT(cal_date, \'yyyy-MM-dd\')' => $today
        ])
        ->one();

        if ($tmp_today->holiday == 'Y') {
            return [
                'message' => 'Today is holiday...'
            ];
        }

        $tmp_open = EmpPermitTbl::find()
        ->select([
            'POST_DATE', 'TOTAL_OPEN' => 'SUM(CASE WHEN STATUS = \'O\' THEN 1 ELSE 0 END)'
        ])
        ->where([
            'STATUS' => 'O',
            'FLAG' => 1
        ])->groupBy('POST_DATE')->orderBy('POST_DATE')->all();

        $data_table = '<span style="font-size: 20px;">
            <b><u>Employee Permit (Outstanding) Summary</u></b>
        </span><br/>
        <table class="summary-tbl">
            <thead>
                <tr>
                    <th class="text-center" style="width: 100px;">Date</th>
                    <th class="text-center" style="width: 100px;">Total Open</th>
                </tr>
            </thead>
            <tbody>
                ';
        
        foreach ($tmp_open as $value) {
            $data_table .= '<tr>
                <td class="text-center">' . date('d M Y', strtotime($value->POST_DATE)) . '</td>
                <td class="text-center">' . number_format($value->TOTAL_OPEN) . '</td>
            </tr>';
        }

        $data_table .= '</tbody>
        </table>
        <br/><br/>
        Thanks & Best Regards,<br/>
        YEMI - MIS
        ';

        \Yii::$app->mailer2->compose(['html' => '@app/mail/layouts/html'], [
            'content' => $data_table
        ])
        //->attach(\Yii::$app->basePath. '\web\uploads\temp\\' . $excel_filename)
        ->setFrom(['yemi.pch@gmail.com' => 'YEMI - MIS'])
        ->setTo(['frenky.purnama@music.yamaha.com'])
        //->setTo(['gazalba.briljan@music.yamaha.com', 'hemy.mardianah@music.yamaha.com', 'fredy.agus@music.yamaha.com', 'handayani.ari@music.yamaha.com'])
        //->setCc('frenky.purnama@music.yamaha.com')
        ->setSubject('Employee Permit (Outstanding) Summary')
        ->send();

        return [
            'status' => 'OK',
            'message' => 'Email has been sent...'
        ];
    }

    public function actionSunfishWorkingTime($period = '')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

        $this_time = date('Y-m-d H:i:s');
        $today = date('Y-m-d', strtotime(' -1 day'));
        if ($period == '') {
            $period = date('Ym', strtotime($today));
        }

        $tmp_sunfish = SunfishAttendanceData::find()
        ->where([
            'FORMAT(shiftendtime, \'yyyyMM\')' => $period,
            'attend_judgement' => 'P'
        ])
        //->andWhere(['<>', 'shiftdaily_code', 'OFF'])
        ->andWhere(['<=', 'start_date', date('Y-m-20', strtotime($period . '01'))])
        ->andWhere(['<=', 'CAST(shiftendtime AS date)', $today])
        ->orderBy('shiftendtime')
        ->asArray()
        ->all();

        $tmp_section_arr = [
            '320' => 'Final Assembling',
            '371' => 'Injection Big',
            '372' => 'Injection Medium',
            '370' => 'Injection Small',
            '330' => 'Painting',
            '340A' => 'PCB - Auto',
            '340M' => 'PCB - Manual',
            '360' => 'SMT',
            '350' => 'SPU',
            '310' => 'Sub. Assembling',
            '300' => 'Wood Working',
        ];
        $tmp_data = [];
        $tmp_daily_record = [];
        foreach ($tmp_section_arr as $cost_center_code => $cost_center_name) {
            $direct1 = $direct2 = $direct3 = $indirect1 = $indirect2 = $indirect3 = $total_wfh = 0;
            $direct1_wt = $direct2_wt = $direct3_wt = $indirect1_wt = $indirect2_wt = $indirect3_wt = 0;
            
            if (count($tmp_sunfish) > 0) {
                foreach ($tmp_sunfish as $value) {
                    $tgl = date('Y-m-d', strtotime($value['shiftendtime']));
                    if (!isset($tmp_daily_record[$cost_center_code][$tgl])) {
                        $tmp_daily_record[$cost_center_code][$tgl] = [
                            'name' => $cost_center_name,
                            'direct1' => 0,
                            'direct2' => 0,
                            'direct3' => 0,
                            'direct1_wt' => 0,
                            'direct2_wt' => 0,
                            'direct3_wt' => 0,
                            'indirect1' => 0,
                            'indirect2' => 0,
                            'indirect3' => 0,
                            'indirect1_wt' => 0,
                            'indirect2_wt' => 0,
                            'indirect3_wt' => 0,
                            'total_wfh' => 0,
                            'clinic_visit' => 0,
                            'clinic_bed_rest' => 0,
                            'clinic_lactation' => 0,
                            'chorei_syuurei' => 0,
                            'mp_intake' => 0,
                        ];
                    }
                    if ($cost_center_name == $value['cost_center']) {
                        if (strpos($value['Attend_Code'], 'STWFH') !== false) {
                            $total_wfh++;
                            $tmp_daily_record[$cost_center_code][$tgl]['total_wfh']++;
                        }
                        if (date('Y-m-d', strtotime($value['start_date'])) == date('Y-m-d', strtotime($value['shiftstarttime']))) {
                            $tmp_daily_record[$cost_center_code][$tgl]['mp_intake']++;
                        }
                        if (strpos(strtoupper($value['shiftdaily_code']), 'SHIFT_1') !== false
                            || strpos(strtoupper($value['shiftdaily_code']), 'SHIFT_08_17') !== false
                            || strpos(strtoupper($value['shiftdaily_code']), 'GARDENER') !== false) {
                            $working_time =  460;
                            if($value['total_ot'] != null){
                                $working_time += $value['total_ot'];
                            }
                            if ($value['jobstatusname_en'] == 'Direct') {
                                $direct1++;
                                $direct1_wt += $working_time;
                                $tmp_daily_record[$cost_center_code][$tgl]['direct1']++;
                                $tmp_daily_record[$cost_center_code][$tgl]['direct1_wt'] += $working_time;
                            } elseif ($value['jobstatusname_en'] == 'Indirect') {
                                $indirect1++;
                                $indirect1_wt += $working_time;
                                $tmp_daily_record[$cost_center_code][$tgl]['indirect1']++;
                                $tmp_daily_record[$cost_center_code][$tgl]['indirect1_wt'] += $working_time;
                            }
                        } elseif (strpos(strtoupper($value['shiftdaily_code']), 'SHIFT_2') !== false || strpos(strtoupper($value['shiftdaily_code']), 'MAINTENANCE') !== false) {
                            $working_time =  450;
                                if($value['total_ot'] != null){
                                    $working_time += $value['total_ot'];
                                }
                            if ($value['jobstatusname_en'] == 'Direct') {
                                $direct2++;
                                $direct2_wt += $working_time;
                                $tmp_daily_record[$cost_center_code][$tgl]['direct2']++;
                                $tmp_daily_record[$cost_center_code][$tgl]['direct2_wt'] += $working_time;
                            } elseif ($value['jobstatusname_en'] == 'Indirect') {
                                $indirect2++;
                                $indirect2_wt += $working_time;
                                $tmp_daily_record[$cost_center_code][$tgl]['indirect2']++;
                                $tmp_daily_record[$cost_center_code][$tgl]['indirect2_wt'] += $working_time;
                            }
                        } elseif (strpos(strtoupper($value['shiftdaily_code']), 'SHIFT_3') !== false) {
                            $working_time =  420;
                                if($value['total_ot'] != null){
                                    $working_time += $value['total_ot'];
                                }
                            if ($value['jobstatusname_en'] == 'Direct') {
                                $direct3++;
                                $direct3_wt += $working_time;
                                $tmp_daily_record[$cost_center_code][$tgl]['direct3']++;
                                $tmp_daily_record[$cost_center_code][$tgl]['direct3_wt'] += $working_time;
                            } elseif ($value['jobstatusname_en'] == 'Indirect') {
                                $indirect3++;
                                $indirect3_wt += $working_time;
                                $tmp_daily_record[$cost_center_code][$tgl]['indirect3']++;
                                $tmp_daily_record[$cost_center_code][$tgl]['indirect3_wt'] += $working_time;
                            }
                        } else {
                            if (strpos(strtoupper($value['Attend_Code']), 'PRSOFF') !== false) {
                                $working_time =  0;
                                if($value['total_ot'] != null){
                                    $working_time += $value['total_ot'];
                                }
                                if ($value['jobstatusname_en'] == 'Direct') {
                                    $direct1++;
                                    $direct1_wt += $working_time;
                                    $tmp_daily_record[$cost_center_code][$tgl]['direct1']++;
                                    $tmp_daily_record[$cost_center_code][$tgl]['direct1_wt'] += $working_time;
                                } elseif ($value['jobstatusname_en'] == 'Indirect') {
                                    $indirect1++;
                                    $indirect1_wt += $working_time;
                                    $tmp_daily_record[$cost_center_code][$tgl]['indirect1']++;
                                    $tmp_daily_record[$cost_center_code][$tgl]['indirect1_wt'] += $working_time;
                                }
                            } else {
                                $working_time =  0;
                            }
                            
                        }


                    }
                }
            }
            
            $tmp_data[$cost_center_code] = [
                'cost_center_name' => $cost_center_name,
                'total_wfh' => $total_wfh,
                'shift1' => [
                    'direct_mp' => $direct1,
                    'direct_wt' => $direct1_wt,
                    'indirect_mp' => $indirect1,
                    'indirect_wt' => $indirect1_wt,
                ],
                'shift2' => [
                    'direct_mp' => $direct2,
                    'direct_wt' => $direct2_wt,
                    'indirect_mp' => $indirect2,
                    'indirect_wt' => $indirect2_wt,
                ],
                'shift3' => [
                    'direct_mp' => $direct3,
                    'direct_wt' => $direct3_wt,
                    'indirect_mp' => $indirect3,
                    'indirect_wt' => $indirect3_wt,
                ],
            ];
        }

        $server_wt_arr = ArrayHelper::map(SunfishWorkingTime::find()->where(['PERIOD' => $period])->all(), 'ID', 'ID');
        $last_update = date('Y-m-d H:i:s');
        foreach ($tmp_data as $cost_center_code => $value) {
            $tmp_server_data = SunfishWorkingTime::find()->where(['ID' => $period . '_' . $cost_center_code])->one();
            if (!$tmp_server_data) {
                $tmp_server_data = new SunfishWorkingTime;
                $tmp_server_data->PERIOD = $period;
                $tmp_server_data->ID = $period . '_' . $cost_center_code;
                $tmp_server_data->COST_CENTER_CODE = '' . $cost_center_code;
                $tmp_server_data->COST_CENTER_NAME = $value['cost_center_name'];
            }

            $tmp_server_data->SHIFT1_DIRECT_MP = $value['shift1']['direct_mp'];
            $tmp_server_data->SHIFT2_DIRECT_MP = $value['shift2']['direct_mp'];
            $tmp_server_data->SHIFT3_DIRECT_MP = $value['shift3']['direct_mp'];
            $tmp_server_data->SHIFT1_DIRECT_WT = $value['shift1']['direct_wt'];
            $tmp_server_data->SHIFT2_DIRECT_WT = $value['shift2']['direct_wt'];
            $tmp_server_data->SHIFT3_DIRECT_WT = $value['shift3']['direct_wt'];

            $tmp_server_data->SHIFT1_INDIRECT_MP = $value['shift1']['indirect_mp'];
            $tmp_server_data->SHIFT2_INDIRECT_MP = $value['shift2']['indirect_mp'];
            $tmp_server_data->SHIFT3_INDIRECT_MP = $value['shift3']['indirect_mp'];
            $tmp_server_data->SHIFT1_INDIRECT_WT = $value['shift1']['indirect_wt'];
            $tmp_server_data->SHIFT2_INDIRECT_WT = $value['shift2']['indirect_wt'];
            $tmp_server_data->SHIFT3_INDIRECT_WT = $value['shift3']['indirect_wt'];

            $tmp_server_data->LAST_UPDATE = $last_update;
            $tmp_server_data->TOTAL_WFH = $value['total_wfh'];

            if (!$tmp_server_data->save()) {
                return $tmp_server_data->errors;
            }
        }

        $clinic_visit = ClinicDailyVisitBySection::find()->where(['period' => $period])->all();

        foreach ($tmp_daily_record as $cost_center_code => $daily_record_arr) {
            foreach ($daily_record_arr as $tgl => $arr_val) {
                $tmp_total_visit = $tmp_total_bedrest = $tmp_total_lactation = 0;
                foreach ($clinic_visit as $clinic_visit_val) {
                    if ($clinic_visit_val->cost_center_code == $cost_center_code && $clinic_visit_val->post_date == $tgl) {
                        $tmp_total_visit = $clinic_visit_val->total_clinic_visit;
                        $tmp_total_bedrest = $clinic_visit_val->total_bed_rest;
                        $tmp_total_lactation = $clinic_visit_val->total_lactation;
                    }
                }
                $id = date('Ymd', strtotime($tgl)) . '_' . $cost_center_code;
                $daily_record = SunfishWorkingTimeDaily::find()->where(['ID' => $id])->one();
                $total_mp = $arr_val['direct1'] + $arr_val['direct2'] + $arr_val['direct3'] + $arr_val['indirect1'] + $arr_val['indirect2'] + $arr_val['indirect3'];
                $total_chorei_shurei = $total_mp * 10;

                if (!$daily_record) {
                    $daily_record = new SunfishWorkingTimeDaily;
                    $daily_record->ID = $id;
                    $daily_record->PERIOD = $period;
                    $daily_record->POST_DATE = $tgl;
                    $daily_record->COST_CENTER_CODE = '' . $cost_center_code;
                    $daily_record->COST_CENTER_NAME = $arr_val['name'];
                }
                $daily_record->MP_DIRECT_1 = $arr_val['direct1'];
                $daily_record->MP_DIRECT_2 = $arr_val['direct2'];
                $daily_record->MP_DIRECT_3 = $arr_val['direct3'];
                $daily_record->MPT_DIRECT_1 = $arr_val['direct1_wt'];
                $daily_record->MPT_DIRECT_2 = $arr_val['direct2_wt'];
                $daily_record->MPT_DIRECT_3 = $arr_val['direct3_wt'];
                $daily_record->MP_INDIRECT_1 = $arr_val['indirect1'];
                $daily_record->MP_INDIRECT_2 = $arr_val['indirect2'];
                $daily_record->MP_INDIRECT_3 = $arr_val['indirect3'];
                $daily_record->MPT_INDIRECT_1 = $arr_val['indirect1_wt'];
                $daily_record->MPT_INDIRECT_2 = $arr_val['indirect2_wt'];
                $daily_record->MPT_INDIRECT_3 = $arr_val['indirect3_wt'];
                $daily_record->TOTAL_WFH = $arr_val['total_wfh'];
                $daily_record->TOTAL_WFH_TIME = $arr_val['total_wfh'] * 480;
                $daily_record->CHOREI_SYUUREI = $total_chorei_shurei;
                $daily_record->TOTAL_MP_INTAKE = $arr_val['mp_intake'];
                $daily_record->MP_INTAKE_TIME = $arr_val['mp_intake'] * 2 * 460;

                $daily_record->CLINIC_VISIT = $tmp_total_visit;
                $daily_record->CLINIC_BED_REST = $tmp_total_bedrest;
                $daily_record->CLINIC_LACTATION = $tmp_total_lactation;

                $daily_record->CLINIC_VISIT_TIME = $tmp_total_visit * 10;
                $daily_record->CLINIC_BED_REST_TIME = $tmp_total_bedrest * 60;
                $daily_record->CLINIC_LACTATION_TIME = $tmp_total_lactation * 60;

                $daily_record->LAST_UPDATE = $this_time;

                if (!$daily_record->save()) {
                    return $daily_record->errors;
                }
            }
        }

        $total_s = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        return 'Total time : ' . $total_s;

        return $tmp_daily_record;

        return $tmp_data;

        
    }

    public function actionUpdateSoProdPlanActual($value='')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

        $last_month_period = date('Ym', strtotime('-1 month'));
        $this_time = date('Y-m-d H:i:s');

        $tmp_so_arr = SoPeriodPlanActual::find()->where(['>=', 'PERIOD', $last_month_period])->all();
        $tmp_serno_arr = SernoOutput::find()->select([
            'id',
            'gmc',
            'total_qty' => 'SUM(output)'
        ])->where(['>=', 'id', $last_month_period])->groupBy('id, gmc')->all();

        foreach ($tmp_so_arr as $so_val) {
            foreach ($tmp_serno_arr as $serno_val) {
                if ($so_val->ITEM == $serno_val->gmc && $so_val->PERIOD == $serno_val->id && $so_val->ACTUAL_QTY != $serno_val->total_qty) {
                    $for_update = SoPeriodPlanActual::find()->where([
                        'PERIOD' => $so_val->PERIOD,
                        'ITEM' => $so_val->ITEM
                    ])->one();
                    $for_update->ACTUAL_QTY = $serno_val->total_qty;
                    $for_update->BALANCE_QTY = $for_update->ACTUAL_QTY - $for_update->PLAN_QTY;
                    $for_update->ACT_QTY_LAST_UPDATE = $this_time;
                    $for_update->ACTUAL_AMT = $for_update->ACTUAL_QTY * $for_update->STANDARD_PRICE;
                    $for_update->BALANCE_AMT = $for_update->ACTUAL_AMT - $for_update->PLAN_AMT;
                    $for_update->save();
                }
            }
        }

        $total_s = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        return 'Total time : ' . $total_s;
    }

    public function actionInjectionMoldingCount()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

        $master_data = InjMachineTbl::find()->all();
        $today = date('Y-m-d');
        $period = date('Ym');
        $last_update = date('Y-m-d H:i:s');

        foreach ($master_data as $master_data_val) {
            $last_log = InjMachineMoldingLog::find()->where([
                'MACHINE_ID' => $master_data_val->MACHINE_ID
            ])->orderBy('START_TIME DESC')->one();

            $master_data = InjMachineTbl::find()->where(['MACHINE_ID' => $master_data_val->MACHINE_ID])->one();
            $current_status = MachineIotCurrentMnt::find()->where(['mesin_id' => $master_data_val->MACHINE_ID])->one();
            if (!$last_log) {
                $new_log = new InjMachineMoldingLog;
                $new_log->ID = strtotime($last_update) . '_' . $master_data_val->MACHINE_ID;
                $new_log->POST_DATE = $today;
                $new_log->PERIOD = $period;
                $new_log->MACHINE_ID = $master_data_val->MACHINE_ID;
                $new_log->MACHINE_DESC = $master_data_val->MACHINE_DESC;
                $new_log->ITEM = $master_data_val->ITEM;
                $new_log->ITEM_DESC = $master_data_val->ITEM_DESC;
                $new_log->COLOR_STATUS = $current_status->status_warna;
                $new_log->START_TIME = $last_update;
                $new_log->MOLDING_ID = $master_data_val->MOLDING_ID;
                $new_log->MOLDING_NAME = $master_data_val->MOLDING_NAME;

                if (!$new_log->save()) {
                    return json_encode($new_log->errors);
                }

                if ($current_status->status_warna == 'Green') {

                    $tmp_total_count = 0;
                    if ($master_data_val->MOLDING_ID != null) {
                        $molding = InjMoldingTbl::findOne($master_data_val->MOLDING_ID);
                        $molding->TOTAL_COUNT++;
                        $molding->SHOT_PCT = 0;
                        if($molding->TARGET_COUNT > 0){
                            $molding->SHOT_PCT = round(($molding->TOTAL_COUNT / $molding->TARGET_COUNT) * 100, 1);
                        }
                        //$molding->CURRENT_COUNT++;
                        $molding->LAST_UPDATE = $last_update;

                        if (!$molding->save()) {
                            return json_encode($molding->errors);
                        }
                        $tmp_total_count = $molding->TOTAL_COUNT;
                    }

                    $master_data->TOTAL_COUNT = $tmp_total_count;
                    $master_data->LAST_UPDATE = $last_update;
                    if (!$master_data->save()) {
                        return json_encode($master_data->errors);
                    }
                }
            } else {
                if ($current_status->status_warna != $last_log->COLOR_STATUS) {
                    $last_log->END_TIME = $last_update;
                    $last_log->TOTAL_TIME_SECOND = strtotime($last_log->END_TIME) - strtotime($last_log->START_TIME);
                    if (!$last_log->save()) {
                        return json_encode($last_log->errors);
                    } else {
                        $new_log = new InjMachineMoldingLog;
                        $new_log->ID = strtotime($last_update) . '_' . $master_data_val->MACHINE_ID;
                        $new_log->POST_DATE = $today;
                        $new_log->PERIOD = $period;
                        $new_log->MACHINE_ID = $master_data_val->MACHINE_ID;
                        $new_log->MACHINE_DESC = $master_data_val->MACHINE_DESC;
                        $new_log->ITEM = $master_data_val->ITEM;
                        $new_log->ITEM_DESC = $master_data_val->ITEM_DESC;
                        $new_log->COLOR_STATUS = $current_status->status_warna;
                        $new_log->START_TIME = $last_update;
                        $new_log->MOLDING_ID = $master_data_val->MOLDING_ID;
                        $new_log->MOLDING_NAME = $master_data_val->MOLDING_NAME;

                        if (!$new_log->save()) {
                            return json_encode($new_log->errors);
                        }
                    }

                    if ($current_status->status_warna == 'Green') {
                        
                        $tmp_total_count = 0;
                        if ($master_data_val->MOLDING_ID != null) {
                            $molding = InjMoldingTbl::findOne($master_data_val->MOLDING_ID);
                            $molding->TOTAL_COUNT++;
                            $molding->SHOT_PCT = 0;
                            if($molding->TARGET_COUNT > 0){
                                $molding->SHOT_PCT = round(($molding->TOTAL_COUNT / $molding->TARGET_COUNT) * 100, 1);
                            }
                            //$molding->CURRENT_COUNT++;
                            $molding->LAST_UPDATE = $last_update;

                            if (!$molding->save()) {
                                return json_encode($molding->errors);
                            }
                            $tmp_total_count = $molding->TOTAL_COUNT;
                        }

                        $master_data->TOTAL_COUNT = $tmp_total_count;
                        $master_data->LAST_UPDATE = $last_update;
                        if (!$master_data->save()) {
                            return json_encode($master_data->errors);
                        }
                    }
                }
            }
        }

        return [];
    }

    public function actionGetDrsData($from_date, $to_date)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

        $tmp_data = DrsView03::find()
        ->where([
            'AND',
            ['>=', 'DRS_DATE', $from_date . ' 00:00:00'],
            ['<=', 'DRS_DATE', $to_date . ' 23:59:59']
        ])
        ->asArray()
        ->all();

        return $tmp_data;
    }

    public function actionUpdateMachineIotLog($value='')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

        $tmp_iot_single = MachineIotSingle::find()
        ->where([
            'mesin_id' => 'MNT00022',
            'FORMAT(jam_start, \'yyyy-MM-dd\')' => '2020-12-14',
            //'jam_no' => 7
        ])
        ->orderBy('jam_start')
        ->all();

        $tmp_data = [];
        foreach ($tmp_iot_single as $key => $value) {
            $datetime_start = $value->jam_start;
            $datetime_end = $value->jam_end;
            $tmp_post_date = date('Y-m-d', strtotime($datetime_start));
            $tmp_jam_start = date('H', strtotime($datetime_start));
            $tmp_jam_end = date('H', strtotime($datetime_end));
            $tmp_status_warna = $value->status_warna;
            $tmp_id = date('Ymd', strtotime($tmp_post_date)) . '_' . (int)$tmp_jam_start . '_' . $value->mesin_id;
            if (!isset($tmp_data[$tmp_id]['MESIN_ID'])) {
                $tmp_data[$tmp_id]['MESIN_ID'] = $value->mesin_id;
                $tmp_data[$tmp_id]['MESIN_DESC'] = $value->mesin_description;
                $tmp_data[$tmp_id]['MERAH'] = 0;
                $tmp_data[$tmp_id]['KUNING'] = 0;
                $tmp_data[$tmp_id]['HIJAU'] = 0;
                $tmp_data[$tmp_id]['BIRU'] = 0;
                $tmp_data[$tmp_id]['PUTIH'] = 0;
                $tmp_data[$tmp_id]['HITAM'] = 0;
            }
            if ($tmp_jam_start == $tmp_jam_end) {
                $tmp_data[$tmp_id][$tmp_status_warna] += $value->count;
            } else {
                $datetime_start2 = date('Y-m-d H:59:59', strtotime($datetime_start));
                $tmp_data[$tmp_id][$tmp_status_warna] += strtotime($datetime_start2) - strtotime($datetime_start);
                $begin = new \DateTime(date('Y-m-d H:00:00', strtotime($datetime_start . ' +1 hour')));
                $end = new \DateTime(date('Y-m-d H:00:00', strtotime($datetime_end)));
                $tmp_datetime_start = $datetime_start;
                for($i = $begin; $i <= $end; $i->modify('+1 hour')){
                    $tgl_waktu = $i->format("Y-m-d H:00:00");
                    $tmp_id = $i->format("Ymd") . '_' . $i->format("H") . '_' . $value->mesin_id;
                    if ($i->format("H") != $tmp_jam_end) {
                        $tmp_data[$tmp_id][$tmp_status_warna] += 3600;
                    } else {
                        $tmp_second = strtotime($datetime_end) - strtotime($tgl_waktu);
                        $tmp_data[$tmp_id][$tmp_status_warna] += $tmp_second;
                    }
                }
            }
        }

        return $tmp_data;
    }

    public function actionDailyIncomingMaterial($from_date, $to_date)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

        $tmp_data = StoreInOutWsus::find()
        ->select([
            'SEQ_LOG', 'POST_DATE', 'ITEM', 'ITEM_DESC', 'LOC', 'LOC_DESC', 'TOTAL_COUNT' => 'COUNT(SEQ_LOG)', 'TOTAL_QTY' => 'SUM(QTY_IN)', 'Judgement'
        ])
        ->where([
            'AND',
            ['>=', 'POST_DATE', $from_date . ' 00:00:00'],
            ['<=', 'POST_DATE', $to_date . ' 23:59:59']
        ])
        ->andWhere(['TRANS_ID' => '11'])
        ->groupBy('SEQ_LOG, POST_DATE, ITEM, ITEM_DESC, LOC, LOC_DESC, Judgement')
        ->orderBy('POST_DATE')
        ->asArray()
        ->all();

        return $tmp_data;
    }

    public function actionClinicDailyVisit($from_date = '', $to_date = '')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

        if ($from_date == '') {
            $from_date = date('Y-m-01', strtotime(' -1 month'));
        }
        if ($to_date == '') {
            $to_date = date('Y-m-t', strtotime(' -1 month'));
        }

        $tmp_data = KlinikInput::find()
        ->select([
            'input_date' => 'date(pk)', 'nik_sun_fish', 'nama', 'cost_center_name', 'status_karyawan', 'opsi'
        ])
        ->where([
            'AND',
            ['>=', 'date(pk)', $from_date],
            ['<=', 'date(pk)', $to_date]
        ])
        ->asArray()
        ->all();

        return $tmp_data;
    }

    public function actionTotalEmpByJoinDate($from_date = '', $to_date = '')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

        if ($from_date == '') {
            $from_date = date('Y-m-01', strtotime(' -1 month'));
        }
        if ($to_date == '') {
            $to_date = date('Y-m-t', strtotime(' -1 month'));
        }

        $tmp_data = SunfishViewEmp::find()
        ->select([
            'start_date' => 'FORMAT(start_date, \'yyyy-MM-dd\')', 'cost_center_code', 'cost_center_name',
            'total_mp' => 'COUNT(Emp_no)'
        ])
        ->where([
            'AND',
            ['>=', 'FORMAT(start_date, \'yyyy-MM-dd\')', $from_date],
            ['<=', 'FORMAT(start_date, \'yyyy-MM-dd\')', $to_date]
        ])
        //->andWhere(['status' => 1])
        ->andWhere(['NOT IN', 'cost_center_code', ['10', '110X']])
        ->andWhere('PATINDEX(\'YE%\', Emp_no) > 0')
        ->groupBy(['FORMAT(start_date, \'yyyy-MM-dd\')', 'cost_center_code', 'cost_center_name'])
        ->orderBy('start_date, cost_center_name')
        ->asArray()
        ->all();

        return $tmp_data;
    }

    public function actionSendNgByModel($model_name)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');

        $sql = "{CALL NEW_MODEL_PROGRESS_BY_MODEL(:MODEL)}";
        $params[':MODEL'] = $model_name;
        $response['data'] = '';

        try {
            $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryOne();
            $result_data = $result['body'];
            $response['data'] = $result_data;
        } catch (Exception $ex) {
            return [
                'message' => 'Failed to get data...!'
            ];
        }

        $email = \Yii::$app->mailer2->compose(['html' => '@app/mail/layouts/empty'], [
            'content' => $response['data']
        ]);
        $email->attach(\Yii::$app->basePath. '\web\mita_insight.png');
        $email->setFrom(['yemi.pch@gmail.com' => 'YEMI - MIS'])
        ->setTo(['gazalba.briljan@music.yamaha.com', 'yunan.prawoto@music.yamaha.com', 'abdul.ghofur@music.yamaha.com', 'muhammad.zamroni@music.yamaha.com', 'sony.wisantomo@music.yamaha.com', 'masatoshi.nasuda@music.yamaha.com', 'satriya.wibowo@music.yamaha.com', 'fredy.agus@music.yamaha.com'])
        //->setCc($set_to_cc_arr)
        ->setSubject($model_name . ' OQC Monitoring')
        ->send();
        
        return [
            'message' => 'Email send...'
        ];
    }

    public function actionSendFgsStock($value='')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        //$today = '2020-10-25';

        $tmp_today = WorkDayTbl::find()
        ->where([
            'FORMAT(cal_date, \'yyyy-MM-dd\')' => $today
        ])
        ->one();

        if ($tmp_today->holiday == 'Y') {
            return [
                'message' => 'Today is holiday...'
            ];
        }

        $tmp_yesterday = WorkDayTbl::find()
        ->select([
            'cal_date' => 'FORMAT(cal_date, \'yyyy-MM-dd\')'
        ])
        ->where([
            '<', 'FORMAT(cal_date, \'yyyy-MM-dd\')', $today
        ])
        ->andWhere('holiday IS NULL')
        ->orderBy('cal_date DESC')
        ->one();
        $yesterday = date('Y-m-d', strtotime($tmp_yesterday->cal_date));

        $tmp_shipping_period = ShippingPeriod::find()
        ->where('ENDING_AMT IS NOT NULL')
        ->orderBy('ENDING_AMT DESC')
        ->all();

        $serno_master_dst_arr = ArrayHelper::map(SernoMaster::find()->select('dest')->where(['!=', 'dest', ''])->andWhere('dest IS NOT NULL')->groupBy('dest')->all(), 'dest', 'dest');
        $tmp_serno_master = ArrayHelper::map(SernoMaster::find()->where(['!=', 'dest', ''])->andWhere('dest IS NOT NULL')->all(), 'gmc', 'dest');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'GMC');
        $sheet->setCellValue('B1', 'Description');
        $sheet->setCellValue('C1', 'Destination');
        $sheet->setCellValue('D1', 'Qty (Sets)');
        $sheet->setCellValue('E1', 'Amount (USD)');
        $sheet->setCellValue('F1', 'M3');

        $tmp_data_qty = $tmp_data_amt = $tmp_data_m3 = [];
        $grandtotal_qty = $grandtotal_amount = $grandtotal_m3 = 0;
        $row = 1;
        foreach ($tmp_shipping_period as $ship_val) {
            $row++;
            $destination = 'N/A';
            if ($ship_val->DESTINATION != '-' AND $ship_val->DESTINATION != null) {
                $destination = $ship_val->DESTINATION;
            }
            /*if (isset($tmp_serno_master[$ship_val->ITEM])) {
                $destination = $tmp_serno_master[$ship_val->ITEM];
            }*/

            if (!isset($tmp_data_qty[$destination])) {
                $tmp_data_qty[$destination] = 0;
            }
            if (!isset($tmp_data_amt[$destination])) {
                $tmp_data_amt[$destination] = 0;
            }
            if (!isset($tmp_data_m3[$destination])) {
                $tmp_data_m3[$destination] = 0;
            }

            $tmp_data_qty[$destination] += $ship_val->ENDING_QTY;
            $tmp_data_amt[$destination] += $ship_val->ENDING_AMT;
            $tmp_data_m3[$destination] += round($ship_val->ENDING_M3);

            $grandtotal_qty += $ship_val->ENDING_QTY;
            $grandtotal_amount += $ship_val->ENDING_AMT;
            $grandtotal_m3 += round($ship_val->ENDING_M3);

            $sheet->setCellValue('A' . $row, $ship_val->ITEM);
            $sheet->setCellValue('B' . $row, $ship_val->material_description);
            $sheet->setCellValue('C' . $row, $destination);
            $sheet->setCellValue('D' . $row, $ship_val->ENDING_QTY);
            $sheet->setCellValue('E' . $row, $ship_val->ENDING_AMT);
            $sheet->setCellValue('F' . $row, round($ship_val->ENDING_M3));
        }

        $excel_filename = 'FGS Stock (Non Booking).xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save('uploads/temp/' . $excel_filename);

        foreach ($serno_master_dst_arr as $dest_val) {
            if (!isset($tmp_data_qty[$dest_val])) {
                $tmp_data_qty[$dest_val] = 0;
            }
            if (!isset($tmp_data_amt[$dest_val])) {
                $tmp_data_amt[$dest_val] = 0;
            }
            if (!isset($tmp_data_m3[$dest_val])) {
                $tmp_data_m3[$dest_val] = 0;
            }
        }

        arsort($tmp_data_amt);

        $yesterday_indo_format = date('d M\' Y', strtotime($yesterday));
        $data_table = '<span style="font-size: 20px;">
            <b><u>FGS STOCK (Non Booking) ' . $yesterday_indo_format . '</u></b>
        </span><br/>
        <span style="font-size: 20px; font-weight: bold; font-family: Arial, sans-serif;">船予約待ちの完成品在庫</span>
        <ul>
            <li>Qty (sets) : ' . number_format($grandtotal_qty) . '</li>
            <li>Amount (USD) : ' . number_format($grandtotal_amount) . '</li>
            <li>M3 : ' . number_format($grandtotal_m3) . '</li>
        </ul>
        <table class="summary-tbl">
            <thead>
                <tr>
                    <th class="text-center" style="width: 100px;">Dest</th>
                    <th class="text-center" style="width: 100px;">Qty (sets)</th>
                    <th class="text-center" style="width: 100px;">Amount (USD)</th>
                    <th class="text-center" style="width: 100px;">M3</th>
                </tr>
            </thead>
            <tbody>
                ';
        
        foreach ($tmp_data_amt as $key => $value) {
            $data_table .= '<tr>
                <td class="text-center">' . $key . '</td>
                <td class="text-center">' . number_format($tmp_data_qty[$key]) . '</td>
                <td class="text-center">' . number_format($value) . '</td>
                <td class="text-center">' . round($tmp_data_m3[$key]) . '</td>
            </tr>';
        }

        $data_table .= '</tbody>
        </table>
        <br/><br/>
        Thanks & Best Regards,<br/>
        YEMI - MIS
        ';

        \Yii::$app->mailer2->compose(['html' => '@app/mail/layouts/html'], [
            'content' => $data_table
        ])
        ->attach(\Yii::$app->basePath. '\web\uploads\temp\\' . $excel_filename)
        ->setFrom(['yemi.pch@gmail.com' => 'YEMI - MIS'])
        //->setTo(['frenky.purnama@music.yamaha.com'])
        ->setTo(['gazalba.briljan@music.yamaha.com', 'hemy.mardianah@music.yamaha.com', 'fredy.agus@music.yamaha.com', 'handayani.ari@music.yamaha.com'])
        //->setCc('frenky.purnama@music.yamaha.com')
        ->setSubject('FGS Stock (' . $yesterday_indo_format . ')')
        ->send();

        return [
            'status' => 'OK',
            'message' => 'Email has been sent...'
        ];
    }

    public function actionPermitSendEmail($set_to = 'frenky.purnama@music.yamaha.com', $set_to_cc = 'ipung.gautama@music.yamaha.com', $id = 'YE1409004202011061033')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $permit_input = PermitInputData::find()->where(['id' => $id])->one();

        if (!$permit_input) {
            return [
                'status' => 'FAILED',
                'message' => 'Item not found...'
            ];
        }

        if ($permit_input->opsi == 1) {
            $status_kembali = 'RETURN';
        } else {
            $status_kembali = 'NO RETURN';
        }

        $msg = 'Dear Mr./Mrs. ' . ucwords(strtolower($permit_input->atasan)) . ',<br/><br/>
        Please confirm the following permit (Link ' . Html::a('HERE', 'http://10.110.52.5:99/plus/index_permit/index_permit_login.php') . '):
        <ul>
            <li>Date : ' . date('d M\' Y', strtotime($permit_input->tgl)) . '</li>
            <li>NIK : ' . $permit_input->nik . '</li>
            <li>Name : ' . $permit_input->nama . '</li>
            <li>Department : ' . $permit_input->dept . '</li>
            <li>Reason : ' . $permit_input->reason . '</li>
            <li>Return Status : ' . $status_kembali . '</li>
        </ul>
        <br/>
        Thanks & Best Regards,<br/>
        MITA
        ';

        $set_to_arr = explode(';', $set_to);
        $set_to_cc_arr = explode(';', $set_to_cc);

        \Yii::$app->mailer2->compose(['html' => '@app/mail/layouts/html'], [
            'content' => $msg
        ])
        ->setFrom(['yemi.pch@gmail.com' => 'YEMI - MIS'])
        ->setTo($set_to_arr)
        //->setCc($set_to_cc_arr)
        ->setSubject('Permit Confirm Notification')
        ->send();

        return [
            'status' => 'OK',
            'message' => 'Email has been sent...'
        ];
    }

    public function actionUpdateSernoMasterBu($value='')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tmp_serno_master = SernoMaster::find()->asArray()->all();
        $tmp_vms_item = VmsItem::find()
        ->select(['ITEM', 'BU', 'FG_KD'])
        ->asArray()
        ->all();
        foreach ($tmp_serno_master as $serno_master) {
            foreach ($tmp_vms_item as $vms_item) {
                if ($serno_master['gmc'] == $vms_item['ITEM']) {
                    $connection = \Yii::$app->db_mis7;
                    $connection->createCommand()->update('tb_serno_master', ['bu' => $vms_item['BU'], 'fg_kd' => $vms_item['FG_KD']], 'gmc = \'' . $serno_master['gmc'] . '\'')->execute();
                }
            }
            /*if (isset($tmp_info_arr[$value->gmc])) {
                $connection = \Yii::$app->db_mis7;
                $connection->createCommand()->update('tb_serno_master', ['bu' => $tmp_info_arr[$value->gmc]], 'gmc = \'' . $value->gmc . '\'')->execute();
            }*/
        }
        return [
            'message' => 'Update Success...'
        ];
    }

    public function actionSendYesterdaySummary($value='')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        //$today = '2020-10-25';

        $tmp_today = WorkDayTbl::find()
        ->where([
            'FORMAT(cal_date, \'yyyy-MM-dd\')' => $today
        ])
        ->one();

        if ($tmp_today->holiday == 'Y') {
            return [
                'message' => 'Today is holiday...'
            ];
        }

        $tmp_yesterday = WorkDayTbl::find()
        ->select([
            'cal_date' => 'FORMAT(cal_date, \'yyyy-MM-dd\')'
        ])
        ->where([
            '<', 'FORMAT(cal_date, \'yyyy-MM-dd\')', $today
        ])
        ->andWhere('holiday IS NULL')
        ->orderBy('cal_date DESC')
        ->one();
        $yesterday = date('Y-m-d', strtotime($tmp_yesterday->cal_date));

        $tmp_yesterday_prod = VmsPlanActual::find()->select('VMS_DATE')->where(['<', 'VMS_DATE', $today])->orderBy('VMS_DATE DESC')->one();
        $yesterday_prod = date('Y-m-d', strtotime($tmp_yesterday_prod->VMS_DATE));

        $yesterday_period = date('Ym', strtotime($yesterday));

        $tmp_prod_daily = VmsPlanActual::find()
        ->select([
            'PLAN_QTY' => 'SUM(PLAN_QTY)',
            'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)',
        ])
        ->where(['VMS_DATE' => $yesterday])
        ->andWhere(['<>', 'LINE', 'SPC'])
        ->one();

        $tmp_prod_daily_fg = VmsPlanActual::find()
        ->select([
            'PLAN_QTY' => 'SUM(PLAN_QTY)',
            'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)',
        ])
        ->where([
            'VMS_DATE' => $yesterday,
            'FG_KD' => 'PRODUCT'
        ])
        ->andWhere(['<>', 'LINE', 'SPC'])
        ->one();

        $tmp_prod_daily_kd = VmsPlanActual::find()
        ->select([
            'PLAN_QTY' => 'SUM(PLAN_QTY)',
            'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)',
        ])
        ->where([
            'VMS_DATE' => $yesterday,
            'FG_KD' => 'KD'
        ])
        ->andWhere(['<>', 'LINE', 'SPC'])
        ->one();

        $tmp_prod_monthly = VmsPlanActual::find()
        ->select([
            'PLAN_QTY' => 'SUM(PLAN_QTY)',
            'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)',
        ])
        ->where(['<=', 'VMS_DATE', $yesterday])
        ->andWhere(['<>', 'LINE', 'SPC'])
        ->andWhere(['FORMAT(VMS_DATE, \'yyyyMM\')' => $yesterday_period])
        ->one();

        $bu_arr  = ['AV' => 0, 'PA' => 0, 'B&O' => 0, 'DMI' => 0, 'PIANO' => 0, 'SN' => 0, 'OTHERS' => 0];
        $tmp_data_arr = [];
        $tmp_so = SernoOutput::find()->select([
            'bu', 'output' => 'SUM(output)'
        ])->where([
            'etd' => $yesterday
        ])
        ->andWhere(['<>', 'line_so', 'SPC'])
        ->groupBy('bu')
        ->asArray()
        ->all();
        $total_shipping = 0;
        foreach ($tmp_so as $key => $value) {
            $total_shipping +=$value['output'];
            $tmp_data_arr[$value['bu']] = $value['output'];
            if (isset($bu_arr[$value['bu']])) {
                $bu_arr[$value['bu']] = $value['output'];
            } else {
                $bu_arr['OTHERS'] += $value['output'];
            }
        }

        $tmp_total_output = SernoInput::find()
        ->select([
            'total' => 'COUNT(pk)'
        ])
        ->where([
            'proddate' => $yesterday,
        ])
        ->one();
        $total_output = $tmp_total_output->total;

        $tmp_total_ng_fa = ProdNgData::find()
        ->select([
            'ng_qty' => 'SUM(ng_qty)'
        ])
        ->where([
            'post_date' => $yesterday,
            'loc_id' => 'WF01',
            'fa_area_detec' => 'OQC'
        ])
        ->one();
        $total_ng = $tmp_total_ng_fa->ng_qty;

        $ng_rate = 0;
        if ($total_output > 0) {
            $ng_rate = round(($total_ng / $total_output) * 100, 2);
        }

        $tmp_top_minus = VmsPlanActual::find()
        ->select([
            'MODEL','ITEM', 'ITEM_DESC', 'DESTINATION',
            'PLAN_QTY' => 'SUM(PLAN_QTY)',
            'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)',
            'BALANCE_QTY' => 'SUM(ACTUAL_QTY - PLAN_QTY)',
        ])
        ->where([
            'VMS_PERIOD' => $yesterday_period,
            //'FG_KD' => 'PRODUCT'
        ])
        ->andWhere(['<', 'FORMAT(VMS_DATE, \'yyyy-MM-dd\')', $today])
        ->andWhere('LINE IS NOT NULL')
        ->andWhere(['<>', 'LINE', 'SPC'])
        ->groupBy('MODEL, ITEM, ITEM_DESC, DESTINATION')
        ->having(['<', 'SUM(ACTUAL_QTY - PLAN_QTY)', 0])
        ->orderBy('SUM(ACTUAL_QTY - PLAN_QTY)')
        ->limit(3)
        ->all();

        $tmp_top_ng = ProdNgData::find()
        ->select([
            'gmc_no', 'gmc_desc', 'ng_qty' => 'SUM(ng_qty)'
        ])
        ->where([
            'post_date' => $yesterday,
            'loc_id' => 'WF01',
            'fa_area_detec' => 'OQC'
        ])
        ->groupBy('gmc_no, gmc_desc')
        ->orderBy('SUM(ng_qty) DESC')
        ->limit(3)->all();

        $tmp_data_present = SunfishAttendanceData::find()
        ->select([
            'total_present' => 'SUM(CASE WHEN attend_judgement = \'P\' THEN 1 ELSE 0 END)',
            'total_mp' => 'COUNT(*)'
        ])
        ->leftJoin('VIEW_YEMI_Emp_OrgUnit', 'VIEW_YEMI_Emp_OrgUnit.Emp_no = VIEW_YEMI_ATTENDANCE.emp_no')
        ->where('PATINDEX(\'YE%\', VIEW_YEMI_ATTENDANCE.emp_no) > 0 AND cost_center NOT IN (\'Expatriate\') AND shiftdaily_code <> \'OFF\'')
        ->andWhere([
            'FORMAT(shiftendtime, \'yyyy-MM-dd\')' => $yesterday
        ])
        ->one();
        $attendance_rate = 0;
        if ($tmp_data_present->total_mp > 0) {
            $attendance_rate = round(($tmp_data_present->total_present / $tmp_data_present->total_mp) * 100, 1);
        }

        $tmp_fg_minus_daily = VmsPlanActual::find()
        ->select([
            'MODEL','ITEM', 'ITEM_DESC', 'DESTINATION',
            'PLAN_QTY' => 'SUM(PLAN_QTY)',
            'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)',
            'BALANCE_QTY' => 'SUM(ACTUAL_QTY - PLAN_QTY)',
        ])
        ->where([
            'FORMAT(VMS_DATE, \'yyyy-MM-dd\')' => $yesterday,
            'FG_KD' => 'PRODUCT'
        ])
        ->andWhere('LINE IS NOT NULL')
        ->andWhere(['<>', 'LINE', 'SPC'])
        ->groupBy('MODEL, ITEM, ITEM_DESC, DESTINATION')
        ->having(['<', 'SUM(ACTUAL_QTY - PLAN_QTY)', 0])
        ->orderBy('SUM(ACTUAL_QTY - PLAN_QTY)')
        ->limit(3)
        ->all();

        $tmp_kd_minus_daily = VmsPlanActual::find()
        ->select([
            'MODEL','ITEM', 'ITEM_DESC', 'DESTINATION',
            'PLAN_QTY' => 'SUM(PLAN_QTY)',
            'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)',
            'BALANCE_QTY' => 'SUM(ACTUAL_QTY - PLAN_QTY)',
        ])
        ->where([
            'FORMAT(VMS_DATE, \'yyyy-MM-dd\')' => $yesterday,
            'FG_KD' => 'KD'
        ])
        ->andWhere('LINE IS NOT NULL')
        ->andWhere(['<>', 'LINE', 'SPC'])
        ->groupBy('MODEL, ITEM, ITEM_DESC, DESTINATION')
        ->having(['<', 'SUM(ACTUAL_QTY - PLAN_QTY)', 0])
        ->orderBy('SUM(ACTUAL_QTY - PLAN_QTY)')
        ->limit(3)
        ->all();

        \Yii::$app->mailer2->compose(['html' => '@app/mail/layouts/yesterday-summary'], [
            'prod_data_daily' => $tmp_prod_daily,
            'prod_data_daily_fg' => $tmp_prod_daily_fg,
            'prod_data_daily_kd' => $tmp_prod_daily_kd,
            'prod_data_monthly' => $tmp_prod_monthly,
            'total_shipping' => $total_shipping,
            'bu_arr' => $bu_arr,
            'tmp_data_arr' => $tmp_data_arr,
            'yesterday' => $yesterday,
            'yesterday_prod' => $yesterday_prod,
            'ng_rate' => $ng_rate,
            'tmp_top_minus' => $tmp_top_minus,
            'tmp_top_ng' => $tmp_top_ng,
            'attendance_rate' => $attendance_rate,
            'tmp_fg_minus_daily' => $tmp_fg_minus_daily,
            'tmp_kd_minus_daily' => $tmp_kd_minus_daily,
        ])
        ->setFrom(['yemi.pch@gmail.com' => 'YEMI - MIS'])
        ->setTo(['gazalba.briljan@music.yamaha.com'])
        //->setCc(array('frenky.purnama@music.yamaha.com'))
        //->setTo(['frenky.purnama@music.yamaha.com'])
        ->setSubject('Production, Shipping, NG and Attendance Report')
        ->send();

        return [
            'message' => 'Email Sent...'
        ];
    }

    public function actionBentolUpdateAll($value='')
    {
        $tmp_1 = $this->actionUpdateBentolTripSummary();
        $tmp_2 = $this->actionCarParkSummaryUpdate();

        $return_msg = [
            'Update Trip Summary' => $tmp_1,
            'Update Car Park Usage' => $tmp_2
        ];

        return $return_msg;
    }

    public function actionCarParkSummaryUpdate($value='')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        $last_month_date = date('Y-m-d', strtotime(' -1 month'));
        if ($last_month_date < '2020-09-01') {
            $last_month_date = '2020-09-01';
        }
        $today = date('Y-m-d');

        $tmp_bentol_summary = BentolManagerTripSummary::find()
        ->where(['>=', 'post_date', $last_month_date])
        ->andWhere(['<=', 'post_date', $today])
        ->all();

        $tmp_car_park_attendance = CarParkAttendance::find()
        ->where(['>=', 'post_date', $last_month_date])
        ->andWhere(['<=', 'post_date', $today])
        ->all();

        $tmp_rfid_scan = RfidCarScan::find()
        ->where(['>=', 'post_date', date('Y-m-d', strtotime($last_month_date . ' -1 day'))])
        ->andWhere(['<=', 'post_date', $today])
        ->all();

        $bulkInsertArray = [];
        $columnNameArray = ['id', 'period', 'post_date', 'emp_id', 'emp_name', 'account_type', 'emp_shift', 'rfid_scan_status', 'parking_status', 'trip_category', 'last_update', 'in_datetime', 'out_datetime', 'start_status', 'end_status', 'start_validation', 'end_validation'];
        $tmp_data = [];
        $total_update = 0;
        foreach ($tmp_bentol_summary as $bentol_summary) {
            $is_found = false;
            foreach ($tmp_car_park_attendance as $car_park_attendance) {
                if ($bentol_summary->id == $car_park_attendance->id) {
                    $is_found = true;
                    $tmp_last_update = $car_park_attendance->last_update;

                }
            }

            $in_date = $out_date = $bentol_summary->post_date;
            if ($bentol_summary->shift_trip == 3) {
                $in_date = date('Y-m-d', strtotime($in_date . ' -1 day'));
            }
            $in_datetime = $out_datetime = null;
            foreach ($tmp_rfid_scan as $rfid_scan) {
                if ($rfid_scan->post_date == $in_date && $rfid_scan->nik == $bentol_summary->emp_id) {
                    if ($bentol_summary->shift_trip == 3) {
                        $in_datetime = $rfid_scan->out_datetime;
                    } else {
                        $in_datetime = $rfid_scan->in_datetime;
                    }
                    
                }
                if ($rfid_scan->post_date == $out_date && $rfid_scan->nik == $bentol_summary->emp_id) {
                    if ($bentol_summary->shift_trip == 3) {
                        $out_datetime = $rfid_scan->in_datetime;
                    } else {
                        $out_datetime = $rfid_scan->out_datetime;
                    }
                    
                }
            }
            if ($in_datetime != null || $out_datetime != null) {
                $rfid_scan_status = 1;
                $parking_status = 1;
            } else {
                $rfid_scan_status = 0;
                if (in_array($bentol_summary->trip_category, ['NORMAL', 'CUTI', 'WFH', 'BUSINESS TRIP'])) {
                    $parking_status = 1;
                } else {
                    $parking_status = 0;
                }
            }
            

            if ($is_found) {
                if ($in_datetime > $tmp_last_update || $out_datetime > $tmp_last_update || $bentol_summary->status_last_update > $tmp_last_update || $bentol_summary->validation_last_update > $tmp_last_update) {
                    $update_data = CarParkAttendance::find()->where(['id' => $bentol_summary->id])->one();
                    $update_data->rfid_scan_status = $rfid_scan_status;
                    $update_data->parking_status = $parking_status;
                    $update_data->emp_shift = $bentol_summary->shift_trip;
                    $update_data->trip_category = $bentol_summary->trip_category;
                    $update_data->last_update = $this_time;
                    $update_data->in_datetime = $in_datetime;
                    $update_data->out_datetime = $out_datetime;
                    $update_data->start_status = $bentol_summary->start_status;
                    $update_data->end_status = $bentol_summary->end_status;
                    $update_data->start_validation = $bentol_summary->start_validation;
                    $update_data->end_validation = $bentol_summary->end_validation;
                    $total_update++;
                    if (!$update_data->save()) {
                        return $models->errors;
                    }
                }
                
            } else {
                
                $bulkInsertArray[] = [$bentol_summary->id, $bentol_summary->period, $bentol_summary->post_date, $bentol_summary->emp_id, $bentol_summary->emp_name, $bentol_summary->account_type, $bentol_summary->shift_trip, $rfid_scan_status, $parking_status, $bentol_summary->trip_category, $this_time, $in_datetime, $out_datetime, $bentol_summary->start_status, $bentol_summary->end_status, $bentol_summary->start_validation, $bentol_summary->end_validation];
            }
        }

        $insertCount = 0;
        if (count($bulkInsertArray) > 0) {
            $insertCount = \Yii::$app->db_sql_server->createCommand()
            ->batchInsert(CarParkAttendance::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
            ->execute();

            //return 'Add Success...(' . $insertCount . ' data - ' . $total_minutes . ' minute(s)';
        } else {
            //return 'No data added ...';
        }
        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);

        return 'Insert : ' . $insertCount . ' | Update : ' . $total_update . ' | Total Time : ' . $total_minutes . ' minute(s)';
    }

    public function actionUpdateBentolTripSummary($post_date = '')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        if ($post_date == '') {
            $post_date = date('Y-m-d');
        }

        $tmp_workday = WorkDayTbl::find()
        ->select([
            'cal_date' => 'FORMAT(cal_date, \'yyyy-MM-dd\')'
        ])
        ->where([
            'FORMAT(cal_date, \'yyyy-MM-dd\')' => $post_date
        ])
        ->andWhere('holiday IS NULL')
        ->one();

        if ($tmp_workday) {
            $bentol_karyawan = BentolKaryawan::find()
            ->where([
                'hak_akses_karyawan' => ['MANAGER', 'COORDINATOR']
            ])
            ->all();

            $bulkInsertArray = [];
            $columnNameArray = ['id', 'period', 'post_date', 'emp_id', 'emp_name', 'account_type', 'shift_trip'];
            $tmp_today_summary = ArrayHelper::map(BentolManagerTripSummary::find()->where([
                'post_date' => $post_date
            ])->all(), 'emp_id', 'emp_id');

            $tmp_attendance = SunfishAttendanceData::find()->where([
                'FORMAT(shiftendtime, \'yyyy-MM-dd\')' => $post_date
            ])->all();

            foreach ($bentol_karyawan as $value) {
                if (!isset($tmp_today_summary[$value->nik_karyawan])) {
                    $id = $post_date . '_' . $value->nik_karyawan;
                    $shift = 1;
                    foreach ($tmp_attendance as $attendance) {
                        if ($attendance->emp_no == $value->nik_karyawan) {
                            if (strpos(strtoupper($attendance->shiftdaily_code), 'SHIFT_1') !== false
                                || strtoupper($attendance->shiftdaily_code) == 'GARDENER'
                                || strtoupper($attendance->shiftdaily_code) == 'SHIFT_08_17') {
                                $shift =  1;
                            } elseif (strpos(strtoupper($attendance->shiftdaily_code), 'SHIFT_2') !== false || strpos(strtoupper($attendance->shiftdaily_code), 'MAINTENANCE') !== false) {
                                $shift =  2;
                            } elseif (strpos(strtoupper($attendance->shiftdaily_code), 'SHIFT_3') !== false) {
                                $shift =  3;
                            } else {
                                $shift =  1;
                            }
                        }
                    }
                    $period = date('Ym', strtotime($post_date));
                    $bulkInsertArray[] = [$id, $period, $post_date, $value->nik_karyawan, $value->nama_karyawan, $value->hak_akses_karyawan, $shift];
                }
            }

            if (count($bulkInsertArray) > 0) {
                $insertCount = \Yii::$app->db_bentol->createCommand()
                ->batchInsert(BentolManagerTripSummary::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
                ->execute();
                
                $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
                $total_minutes = round($process_time / 60, 1);

                return 'Add Success...(' . $insertCount . ' data - ' . $total_minutes . ' minute(s)';
            } else {
                return 'No data added ...';
            }
        } else {
            return 'Holiday ...';
        }
    }

    public function actionSernoOutputUpdateSp($period = '')
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($period == '') {
            $period = date('Ym');
        }

        $tmp_so = SernoOutput::find()->select('gmc')->where([
            'EXTRACT(year_month FROM etd)' => $period
        ])->groupBy('gmc')->orderBy('gmc')->all();
        $vms_item_arr = VmsItem::find()->asArray()->all();
        $sap_item_arr = SapItemTbl::find()->where([
            'analyst' => 'WF01'
        ])->asArray()->all();
        $total_update = count($tmp_so);
        foreach ($tmp_so as $so) {
            $description = $destination = $bu = $line = $model = $fg_kd = $standard_price = null;
            foreach ($vms_item_arr as $vms_item) {
                if ($so['gmc'] == $vms_item['ITEM']) {
                    $description = $vms_item['ITEM_DESC'];
                    $destination = $vms_item['DESTINATION'];
                    $bu = $vms_item['BU'];
                    $line = $vms_item['LINE'];
                    $model = $vms_item['MODEL'];
                    $fg_kd = $vms_item['FG_KD'];
                    //$standard_price = $vms_item['STANDARD_PRICE'];
                }
            }

            foreach ($sap_item_arr as $sap_item) {
                if ($so['gmc'] == $sap_item['material']) {
                    $standard_price = $sap_item['standard_price'];
                }
            }

            SernoOutput::updateAll([
                'gmc_desc' => $description,
                'gmc_destination' => $destination,
                'bu' => $bu,
                'line_so' => $line,
                'model_so' => $model,
                'fg_kd' => $fg_kd,
                'standard_price' => $standard_price,
            ], [
                'EXTRACT(year_month FROM etd)' => $period,
                'gmc' => $so['gmc']
            ]);
        }

        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);

        return 'Update Success...(' . $total_update . ' data - ' . $total_minutes . ' minute(s)';
        
    }

    public function actionUpdateLiveCookingMember()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $tmp_karyawan = SunfishViewEmp::find()
        ->where(['status' => 1])
        ->andWhere('PATINDEX(\'YE%\', Emp_no) > 0')
        ->all();

        $tmp_member = LiveCookingMember::find()->all();

        $bulkInsertArray = [];
        $columnNameArray = ['NIK', 'NAMA_KARYAWAN'];

        foreach ($tmp_karyawan as $karyawan) {
            $is_found = false;
            $nik = $nama_karyawan = '';
            foreach ($tmp_member as $member) {
                if ($member->NIK == $karyawan->Emp_no) {
                    $is_found = true;
                }
            }
            if ($is_found == false) {
                $bulkInsertArray[] = [$karyawan->Emp_no, strtoupper($karyawan->Full_name)];
            }
        }

        $total_insert = count($bulkInsertArray);
        if($total_insert > 0){
            $insertCount = \Yii::$app->db_sql_server->createCommand()
            ->batchInsert(LiveCookingMember::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
            ->execute();
        }

        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);

        return 'Update Success...(' . $total_insert . ' new data) - ' . $total_minutes . ' minute(s)';
    }

    public function actionVmsUpdateAll($post_date='')
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $tmp_1 = $this->actionVmsPlanActualUpdate();
        $tmp_2 = $this->actionVmsUpdateLine();
        $return_msg = [
            'Update Actual' => $tmp_1,
            'Update Line' => $tmp_2
        ];

        return $return_msg;
    }

    public function actionVmsUpdateLine()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $tmp_ijazah = VmsPlanActual::find()
        ->select('ITEM, LINE')
        //->where('LINE IS NULL')
        ->groupBy('ITEM, LINE')
        ->all();

        $tmp_item = [];
        foreach ($tmp_ijazah as $key => $value) {
            $tmp_item[] = $value->ITEM;
        }

        $tmp_serno_master = SernoMaster::find()
        ->where([
            'gmc' => $tmp_item
        ])
        ->all();

        $count = 0;
        foreach ($tmp_serno_master as $serno_master) {
            foreach ($tmp_ijazah as $ijazah) {
                if ($serno_master->gmc == $ijazah->ITEM && $serno_master->line != $ijazah->LINE) {
                    VmsPlanActual::updateAll(['LINE' => $serno_master->line, 'LINE_LAST_UPDATE' => $this_time], ['ITEM' => $serno_master->gmc]);
                    $count++;
                }
            }
        }

        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);

        return 'Update Success...(' . $count . '/' . count($tmp_item) . ') - ' . $total_minutes . ' minute(s)';
    }

    public function actionVmsPlanActualUpdate($value='')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        $current_timestamp = strtotime($this_time);
        $post_date = date('Y-m-d');
        $current_period = date('Ym');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => $current_period
        ])->one();
        $fiscal = $current_fiscal->FISCAL;

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $current_fiscal->FISCAL
        ])
        ->orderBy('PERIOD')
        ->all();

        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        $tmp_output = SernoOutput::find()
        ->select([
            'id', 'gmc', 'output' => 'SUM(output)'
        ])
        ->where([
            'id' => $period_arr
        ])
        ->groupBy('id, gmc')
        ->orderBy('id, gmc')
        ->all();

        $tmp_vms_plan = VmsPlanActual::find()
        ->select([
            'VMS_PERIOD', 'ITEM',
            'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)'
        ])
        ->where([
            'VMS_PERIOD' => $period_arr
        ])
        ->groupBy('VMS_PERIOD, ITEM')
        ->orderBy('VMS_PERIOD, ITEM')
        ->all();

        $tmp_result = [];
        $data = [];
        foreach ($tmp_output as $output) {
            foreach ($tmp_vms_plan as $vms_plan) {
                if ($output->gmc == $vms_plan->ITEM && $output->id == $vms_plan->VMS_PERIOD) {
                    if ($vms_plan->ACTUAL_QTY != $output->output) {
                        $update_return_val = $this->vmsQtyUpdate($output->id, $output->gmc, $output->output);
                        $tmp_result[] = $update_return_val;
                        $data['total_update'] += $update_return_val[$output->id][$output->gmc];
                    }
                }
            }
        }

        $total_minutes = $this->getTotalMinutes($this_time, date('Y-m-d H:i:s'));
        $data['total_minutes'] = $total_minutes;

        $data['result'] = $tmp_result;

        return $data;
    }

    public function getTotalMinutes($start_time, $end_time)
    {
        $process_time = strtotime($end_time) - strtotime($start_time);
        $total_minutes = round($process_time / 60, 1);

        return $total_minutes;
    }

    public function vmsQtyUpdate($period = '202005', $gmc = 'VAS0420', $total_qty = 0)
    {
        date_default_timezone_set('Asia/Jakarta');
        $last_update = date('Y-m-d H:i:s');
        $tmp_arr = VmsPlanActual::find()
        ->where([
            'VMS_PERIOD' => $period,
            'ITEM' => $gmc,
        ])
        ->orderBy('VMS_DATE')
        ->all();
        $total_data = count($tmp_arr);

        $no = $total_update = 0;
        foreach ($tmp_arr as $key => $value) {
            $no++;
            $plan_qty = $value->PLAN_QTY;
            if ($no == $total_data) {
                $actual_qty = $total_qty;
            } else {
                if ($total_qty > $plan_qty) {
                    $actual_qty = $plan_qty;
                    $total_qty -= $plan_qty;
                } else {
                    $actual_qty = $total_qty;
                    $total_qty = 0;
                }
            }
            $balance_qty = $plan_qty - $actual_qty;
            if ($value->ACTUAL_QTY != $actual_qty || $value->BALANCE_QTY != $balance_qty) {
                $data_to_update = VmsPlanActual::findOne($value->ID);
                $data_to_update->ACTUAL_QTY = $actual_qty;
                $data_to_update->BALANCE_QTY = $balance_qty;
                $data_to_update->ACT_QTY_LAST_UPDATE = $last_update;
                $total_update++;
                if (!$data_to_update->save()) {
                    return json_encode($model->errors);
                }
            }
        }

        return [
            $period => [
                $gmc => $total_update
            ]
        ];
    }

    public function actionIjazahUpdateProgress($value='')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        $current_timestamp = strtotime($this_time);
        $post_date = date('Y-m-d');
        $current_period = date('Ym');
        
        $bulkInsertArray = [];
        $columnNameArray = ['ID', 'LINE', 'FY', 'PERIOD', 'DATE', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', 'MAR', 'APR_PLAN_QTY', 'MAY_PLAN_QTY', 'JUN_PLAN_QTY', 'JUL_PLAN_QTY', 'AUG_PLAN_QTY', 'SEP_PLAN_QTY', 'OCT_PLAN_QTY', 'NOV_PLAN_QTY', 'DEC_PLAN_QTY', 'JAN_PLAN_QTY', 'FEB_PLAN_QTY', 'MAR_PLAN_QTY', 'APR_ACT_QTY', 'MAY_ACT_QTY', 'JUN_ACT_QTY', 'JUL_ACT_QTY', 'AUG_ACT_QTY', 'SEP_ACT_QTY', 'OCT_ACT_QTY', 'NOV_ACT_QTY', 'DEC_ACT_QTY', 'JAN_ACT_QTY', 'FEB_ACT_QTY', 'MAR_ACT_QTY', 'APR_BALANCE_QTY', 'MAY_BALANCE_QTY', 'JUN_BALANCE_QTY', 'JUL_BALANCE_QTY', 'AUG_BALANCE_QTY', 'SEP_BALANCE_QTY', 'OCT_BALANCE_QTY', 'NOV_BALANCE_QTY', 'DEC_BALANCE_QTY', 'JAN_BALANCE_QTY', 'FEB_BALANCE_QTY', 'MAR_BALANCE_QTY', 'APR_PCT', 'MAY_PCT', 'JUN_PCT', 'JUL_PCT', 'AUG_PCT', 'SEP_PCT', 'OCT_PCT', 'NOV_PCT', 'DEC_PCT', 'JAN_PCT', 'FEB_PCT', 'MAR_PCT', 'LAST_UPDATE'];

        $line_arr = ArrayHelper::map(SernoMaster::find()
        ->select('line')
        ->where('line != \'\'AND line != \'MIS\'')
        ->groupBy('line')
        ->all(), 'line', 'line');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => $current_period
        ])->one();
        $fiscal = $current_fiscal->FISCAL;

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $current_fiscal->FISCAL
        ])
        ->orderBy('PERIOD')
        ->all();

        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        $tmp_progress = IjazahPlanActual::find()
        ->select([
            'LINE', 'PERIOD',
            'PLAN_AMT' => 'SUM(PLAN_AMT)',
            'ACTUAL_AMT_ALLOC' => 'SUM(ACTUAL_AMT_ALLOC)',
            'PLAN_QTY' => 'SUM(PLAN_QTY)',
            'ACTUAL_QTY_ALLOC' => 'SUM(ACTUAL_QTY_ALLOC)',
        ])
        ->where([
            'PERIOD' => $period_arr
        ])
        //->andWhere(['>', 'PLAN_QTY', 0])
        ->andWhere('LINE IS NOT NULL')
        ->groupBy('LINE, PERIOD')
        ->orderBy('LINE, PERIOD')
        ->all();

        $tmp_data_arr = [];
        /*$period_custom_arr = [
            '04' => 'APR',
            '05' => 'MAY',
            '06' => 'JUN',
            '07' => 'JUL',
            '08' => 'AUG',
            '09' => 'SEP',
            '10' => 'OCT',
            '11' => 'NOV',
            '12' => 'DEC',
            '01' => 'JAN',
            '02' => 'FEB',
            '03' => 'MAR',
        ];*/

        $progress_check = IjazahProgress::find()->where([
            'FORMAT(DATE, \'yyyy-MM-dd\')' => $post_date
        ])
        ->count();
        if ($progress_check == 0) {
            foreach ($line_arr as $line) {
                foreach ($period_arr as $period) {
                    $tmp_plan_amt = $tmp_act_amt = $tmp_plan_qty = $tmp_act_qty = 0;
                    foreach ($tmp_progress as $progress) {
                        if ($progress->LINE == $line && $progress->PERIOD == $period) {
                            $tmp_plan_amt = $progress->PLAN_AMT;
                            $tmp_act_amt = $progress->ACTUAL_AMT_ALLOC;
                            $tmp_plan_qty = $progress->PLAN_QTY;
                            $tmp_act_qty = $progress->ACTUAL_QTY_ALLOC;
                        }
                    }
                    $tmp_pct = 0;
                    if ($tmp_plan_amt > 0) {
                        $tmp_pct = round(($tmp_act_amt / $tmp_plan_amt) * 100, 2);
                    }
                    $tmp_balance_qty = $tmp_plan_qty - $tmp_act_qty;
                    /*$custom_period_index = substr($period, -2);
                    $custom_period = $period_custom_arr[$custom_period_index];*/
                    $tmp_data_arr[$line][] = [
                        'pct' => $tmp_pct,
                        'plan_qty' => $tmp_plan_qty,
                        'act_qty' => $tmp_act_qty,
                        'balance_qty' => $tmp_balance_qty
                    ];
                }
            }

            

            foreach ($tmp_data_arr as $key => $value) {
                $ID = $current_timestamp . '_' . $key;
                $LINE = $key;
                $FY = $fiscal;
                $PERIOD = $current_period;
                $DATE = $post_date;

                $APR = $value[0]['pct'];
                $MAY = $value[1]['pct'];
                $JUN = $value[2]['pct'];
                $JUL = $value[3]['pct'];
                $AUG = $value[4]['pct'];
                $SEP = $value[5]['pct'];
                $OCT = $value[6]['pct'];
                $NOV = $value[7]['pct'];
                $DEC = $value[8]['pct'];
                $JAN = $value[9]['pct'];
                $FEB = $value[10]['pct'];
                $MAR = $value[11]['pct'];

                $APR_PLAN_QTY = $value[0]['plan_qty'];
                $MAY_PLAN_QTY = $value[1]['plan_qty'];
                $JUN_PLAN_QTY = $value[2]['plan_qty'];
                $JUL_PLAN_QTY = $value[3]['plan_qty'];
                $AUG_PLAN_QTY = $value[4]['plan_qty'];
                $SEP_PLAN_QTY = $value[5]['plan_qty'];
                $OCT_PLAN_QTY = $value[6]['plan_qty'];
                $NOV_PLAN_QTY = $value[7]['plan_qty'];
                $DEC_PLAN_QTY = $value[8]['plan_qty'];
                $JAN_PLAN_QTY = $value[9]['plan_qty'];
                $FEB_PLAN_QTY = $value[10]['plan_qty'];
                $MAR_PLAN_QTY = $value[11]['plan_qty'];

                $APR_ACT_QTY = $value[0]['act_qty'];
                $MAY_ACT_QTY = $value[1]['act_qty'];
                $JUN_ACT_QTY = $value[2]['act_qty'];
                $JUL_ACT_QTY = $value[3]['act_qty'];
                $AUG_ACT_QTY = $value[4]['act_qty'];
                $SEP_ACT_QTY = $value[5]['act_qty'];
                $OCT_ACT_QTY = $value[6]['act_qty'];
                $NOV_ACT_QTY = $value[7]['act_qty'];
                $DEC_ACT_QTY = $value[8]['act_qty'];
                $JAN_ACT_QTY = $value[9]['act_qty'];
                $FEB_ACT_QTY = $value[10]['act_qty'];
                $MAR_ACT_QTY = $value[11]['act_qty'];

                $APR_BALANCE_QTY = $value[0]['balance_qty'];
                $MAY_BALANCE_QTY = $value[1]['balance_qty'];
                $JUN_BALANCE_QTY = $value[2]['balance_qty'];
                $JUL_BALANCE_QTY = $value[3]['balance_qty'];
                $AUG_BALANCE_QTY = $value[4]['balance_qty'];
                $SEP_BALANCE_QTY = $value[5]['balance_qty'];
                $OCT_BALANCE_QTY = $value[6]['balance_qty'];
                $NOV_BALANCE_QTY = $value[7]['balance_qty'];
                $DEC_BALANCE_QTY = $value[8]['balance_qty'];
                $JAN_BALANCE_QTY = $value[9]['balance_qty'];
                $FEB_BALANCE_QTY = $value[10]['balance_qty'];
                $MAR_BALANCE_QTY = $value[11]['balance_qty'];

                $last_progress = IjazahProgress::find()
                ->where([
                    'LINE' => $key
                ])
                ->one();
                $APR_PCT = 0;
                $MAY_PCT = 0;
                $JUN_PCT = 0;
                $JUL_PCT = 0;
                $AUG_PCT = 0;
                $SEP_PCT = 0;
                $OCT_PCT = 0;
                $NOV_PCT = 0;
                $DEC_PCT = 0;
                $JAN_PCT = 0;
                $FEB_PCT = 0;
                $MAR_PCT = 0;
                if ($last_progress) {
                    $APR_PCT = $value[0]['pct'] - $last_progress->APR;
                    $MAY_PCT = $value[1]['pct'] - $last_progress->MAY;
                    $JUN_PCT = $value[2]['pct'] - $last_progress->JUN;
                    $JUL_PCT = $value[3]['pct'] - $last_progress->JUL;
                    $AUG_PCT = $value[4]['pct'] - $last_progress->AUG;
                    $SEP_PCT = $value[5]['pct'] - $last_progress->SEP;
                    $OCT_PCT = $value[6]['pct'] - $last_progress->OCT;
                    $NOV_PCT = $value[7]['pct'] - $last_progress->NOV;
                    $DEC_PCT = $value[8]['pct'] - $last_progress->DEC;
                    $JAN_PCT = $value[9]['pct'] - $last_progress->JAN;
                    $FEB_PCT = $value[10]['pct'] - $last_progress->FEB;
                    $MAR_PCT = $value[11]['pct'] - $last_progress->MAR;
                }

                $bulkInsertArray[] = [
                    $ID, $LINE, $FY, $PERIOD, $DATE, $APR, $MAY, $JUN, $JUL, $AUG, $SEP, $OCT, $NOV, $DEC, $JAN, $FEB, $MAR, $APR_PLAN_QTY, $MAY_PLAN_QTY, $JUN_PLAN_QTY, $JUL_PLAN_QTY, $AUG_PLAN_QTY, $SEP_PLAN_QTY, $OCT_PLAN_QTY, $NOV_PLAN_QTY, $DEC_PLAN_QTY, $JAN_PLAN_QTY, $FEB_PLAN_QTY, $MAR_PLAN_QTY, $APR_ACT_QTY, $MAY_ACT_QTY, $JUN_ACT_QTY, $JUL_ACT_QTY, $AUG_ACT_QTY, $SEP_ACT_QTY, $OCT_ACT_QTY, $NOV_ACT_QTY, $DEC_ACT_QTY, $JAN_ACT_QTY, $FEB_ACT_QTY, $MAR_ACT_QTY, $APR_BALANCE_QTY, $MAY_BALANCE_QTY, $JUN_BALANCE_QTY, $JUL_BALANCE_QTY, $AUG_BALANCE_QTY, $SEP_BALANCE_QTY, $OCT_BALANCE_QTY, $NOV_BALANCE_QTY, $DEC_BALANCE_QTY, $JAN_BALANCE_QTY, $FEB_BALANCE_QTY, $MAR_BALANCE_QTY, $APR_PCT, $MAY_PCT, $JUN_PCT, $JUL_PCT, $AUG_PCT, $SEP_PCT, $OCT_PCT, $NOV_PCT, $DEC_PCT, $JAN_PCT, $FEB_PCT, $MAR_PCT, $this_time];
            }
        }
        

        $total_insert = count($bulkInsertArray);
        if($total_insert > 0){
            $insertCount = \Yii::$app->db_sql_server->createCommand()
            ->batchInsert(IjazahProgress::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
            ->execute();
        }

        return $total_insert . ' data(s) inserted...';
    }

    public function actionIjazahUpdateAll($post_date='')
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $tmp_1 = $this->actionIjazahUpdateActual($post_date);
        $tmp_2 = $this->actionIjazahAlloc($post_date);
        $tmp_3 = $this->actionIjazahUpdateLine();
        $return_msg = [
            'Update Original' => $tmp_1,
            'Update Allocation' => $tmp_2,
            'Update Line' => $tmp_3
        ];

        return $return_msg;
    }

    public function getPeriodArr($post_date='')
    {
        if ($post_date == '') {
            $current_period = date('Ym');
        } else {
            $current_period = date('Ym', strtotime($post_date));
        }

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => $current_period
        ])->one();

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $current_fiscal->FISCAL
        ])
        ->andWhere(['<=', 'PERIOD', $current_period])
        ->orderBy('PERIOD')
        ->all();

        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        return $period_arr;
    }

    public function actionIjazahUpdateLine()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $tmp_ijazah = IjazahPlanActual::find()
        ->select('ITEM, LINE')
        //->where('LINE IS NULL')
        ->groupBy('ITEM, LINE')
        ->all();

        $tmp_item = [];
        foreach ($tmp_ijazah as $key => $value) {
            $tmp_item[] = $value->ITEM;
        }

        $tmp_serno_master = SernoMaster::find()
        ->where([
            'gmc' => $tmp_item
        ])
        ->all();

        $count = 0;
        foreach ($tmp_serno_master as $serno_master) {
            foreach ($tmp_ijazah as $ijazah) {
                if ($serno_master->gmc == $ijazah->ITEM && $serno_master->line != $ijazah->LINE) {
                    IjazahPlanActual::updateAll(['LINE' => $serno_master->line, 'LINE_LAST_UPDATE' => $this_time], ['ITEM' => $serno_master->gmc]);
                    $count++;
                }
            }
        }

        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);

        return 'Update Success...(' . $count . '/' . count($tmp_item) . ') - ' . $total_minutes . ' minute(s)';
    }

    public function actionIjazahAlloc($post_date='')
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $period_arr = $this->getPeriodArr($post_date);

        $tmp_ijazah_arr = IjazahPlanActual::find()
        ->where([
            'PERIOD' => $period_arr
        ])
        ->orderBy('ITEM, PERIOD')
        ->all();

        $tmp_total_actual_arr = IjazahPlanActual::find()
        ->select([
            'ITEM', 'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)'
        ])
        ->where([
            'PERIOD' => $period_arr
        ])
        //->andWhere(['>', 'ACTUAL_QTY', 0])
        ->groupBy('ITEM')
        ->all();

        $data_update = 0;
        foreach ($tmp_total_actual_arr as $tmp_total_actual) {
            $total_alloc = $tmp_total_actual->ACTUAL_QTY;
            foreach ($tmp_ijazah_arr as $tmp_ijazah) {
                if ($tmp_total_actual->ITEM == $tmp_ijazah->ITEM) {
                    $tmp_period = $tmp_ijazah->PERIOD;
                    $plan_qty = $tmp_ijazah->PLAN_QTY;
                    if ($total_alloc > $plan_qty) {
                        $actual_qty_alloc = $plan_qty;
                        $total_alloc -= $plan_qty;
                    } else {
                        $actual_qty_alloc = $total_alloc;
                        $total_alloc = 0;
                    }
                    $tmp_balance_qty_alloc = $plan_qty - $actual_qty_alloc;
                    $amt_ratio = 0;
                    if ($plan_qty > 0) {
                        $amt_ratio = round(($actual_qty_alloc / $plan_qty) * 100, 1);
                    }
                    $ACTUAL_AMT_ALLOC = $tmp_ijazah->ACTUAL_QTY_ALLOC * $tmp_ijazah->STD_PRICE;
                    $ACTUAL_AMT_ALLOC_NEW = $actual_qty_alloc * $tmp_ijazah->STD_PRICE;

                    /*if ($actual_qty_alloc != $tmp_ijazah->ACTUAL_QTY_ALLOC
                        || $tmp_ijazah->BALANCE_QTY_ALLOC != $tmp_balance_qty_alloc
                        || $ACTUAL_AMT_ALLOC != $ACTUAL_AMT_ALLOC_NEW
                        || $tmp_ijazah->PLAN_QTY != $plan_qty
                    ) {
                        $update_ijazah = IjazahPlanActual::findOne($tmp_ijazah->ITEM . '-' . $tmp_ijazah->PERIOD);
                        $update_ijazah->ACTUAL_QTY_ALLOC = $actual_qty_alloc;
                        $update_ijazah->BALANCE_QTY_ALLOC = $tmp_balance_qty_alloc;
                        $update_ijazah->ACT_ALLOC_LAST_UPDATE = $this_time;
                        $update_ijazah->PLAN_AMT = $tmp_ijazah->PLAN_QTY * $tmp_ijazah->STD_PRICE;
                        $update_ijazah->ACTUAL_AMT_ALLOC = $ACTUAL_AMT_ALLOC;
                        $update_ijazah->BALANCE_AMT_ALLOC = $tmp_balance_qty_alloc * $tmp_ijazah->STD_PRICE;
                        $update_ijazah->AMT_RATIO = $amt_ratio;
                        if (!$update_ijazah->save()) {
                            return $update_ijazah->errors;
                        }
                        $data_update++;
                    }*/
                    if ($actual_qty_alloc != $tmp_ijazah->ACTUAL_QTY_ALLOC
                        || $tmp_ijazah->BALANCE_QTY_ALLOC != $tmp_balance_qty_alloc
                        || $ACTUAL_AMT_ALLOC != $ACTUAL_AMT_ALLOC_NEW
                        || $tmp_ijazah->PLAN_QTY != $plan_qty
                        || ($tmp_ijazah->PLAN_QTY != $tmp_ijazah->ACTUAL_QTY_ALLOC && ($tmp_ijazah->STD_PRICE * $tmp_ijazah->ACTUAL_QTY_ALLOC) * $tmp_ijazah->ACTUAL_AMT_ALLOC)
                        || ($tmp_ijazah->ACT_ALLOC_LAST_UPDATE < $tmp_ijazah->ACT_LAST_UPDATE)
                        || $tmp_ijazah->ACT_ALLOC_LAST_UPDATE == null
                        || $tmp_ijazah->ACTUAL_AMT_ALLOC != $tmp_ijazah->PLAN_AMT
                    ) {
                        $update_ijazah = IjazahPlanActual::findOne($tmp_ijazah->ITEM . '-' . $tmp_ijazah->PERIOD);
                        $update_ijazah->ACTUAL_QTY_ALLOC = $actual_qty_alloc;
                        $update_ijazah->BALANCE_QTY_ALLOC = $tmp_balance_qty_alloc;
                        $update_ijazah->ACT_ALLOC_LAST_UPDATE = $this_time;
                        $update_ijazah->PLAN_AMT = round($tmp_ijazah->PLAN_QTY * $tmp_ijazah->STD_PRICE, 1);
                        $update_ijazah->ACTUAL_AMT_ALLOC = round($ACTUAL_AMT_ALLOC, 1);
                        $update_ijazah->BALANCE_AMT_ALLOC = round($tmp_balance_qty_alloc * $tmp_ijazah->STD_PRICE, 1);
                        $update_ijazah->AMT_RATIO = $amt_ratio;
                        if (!$update_ijazah->save()) {
                            return $update_ijazah->errors;
                        }
                        $data_update++;
                    }
                    
                }
            }
        }
        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);
        return 'Update ' . $data_update . ' data(s) Success...(' . $total_minutes . ' minute(s))';
    }

    public function actionIjazahUpdateActual($post_date = '')
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $period = $this->getPeriodArr($post_date);
        //return $period;

        $tmp_output = SernoOutput::find()
        ->select([
            'id' ,'gmc', 'output' => 'SUM(output)', 'qty' => 'SUM(qty)'
        ])
        ->where([
            'id' => $period
        ])
        //->andWhere(['>', 'output', 0])
        ->groupBy('id, gmc')
        ->all();

        /*$tmp_plan = ArrayHelper::map(IjazahPlanActual::find()->where([
            'PERIOD' => $period
        ])->all(), 'ID', 'PLAN_QTY');*/

        $tmp_plan2 = IjazahPlanActual::find()->where([
            'PERIOD' => $period
        ])->all();

        $insert_arr = $minus = [];
        //$insert_gmc = [];
        $bulkInsertArray = [];
        $columnNameArray = ['ID', 'PRODUCT_TYPE', 'BU', 'MODEL', 'PERIOD', 'ITEM', 'ITEM_DESC', 'DESTINATION', 'PLAN_QTY', 'ACTUAL_QTY', 'BALANCE_QTY', 'FORECAST_NAME', 'ACT_LAST_UPDATE'];
        $total_insert = $total_update = 0;
        foreach ($tmp_output as $key => $value) {
            $index = $value->gmc . '-' . $value->id;
            $index = strtoupper($index);
            $found = false;
            $tmp_act_qty = $tmp_plan_qty = $tmp_balance_qty = 0;
            $tmp_act_last_update = null;
            foreach ($tmp_plan2 as $plan2) {
                if ($plan2->ID == $index) {
                    $found = true;
                    $tmp_act_qty = $plan2->ACTUAL_QTY;
                    $tmp_plan_qty = $plan2->PLAN_QTY;
                    $tmp_balance_qty = $plan2->BALANCE_QTY;
                    $tmp_act_last_update = $plan2->ACT_LAST_UPDATE;
                }
            }
            if ($found) {
                $balance = $tmp_plan_qty - $value->output;
                if ($value->output != $tmp_act_qty || $value->qty != $tmp_plan_qty || $tmp_act_last_update == null) {
                    $total_update++;
                    $tmp_update = IjazahPlanActual::findOne($index);
                    $tmp_update->ACTUAL_QTY = $value->output;
                    $tmp_update->BALANCE_QTY = $balance;
                    $tmp_update->ACT_LAST_UPDATE = $this_time;
                    if (!$tmp_update->save()) {
                        return $tmp_update->errors;
                    }
                    
                }
            } else {
                $tmp_gmc = IjazahItem::find()->where(['ITEM' => $value->gmc])->one();
                $balance = 0 - $value->output;
                $tmp_insert = [
                    'ID' => $index,
                    'PRODUCT_TYPE' => $tmp_gmc->PRODUCT_TYPE,
                    'BU' => $tmp_gmc->BU,
                    'MODEL' => $tmp_gmc->MODEL,
                    'PERIOD' => $value->id,
                    'ITEM' => $value->gmc,
                    'ITEM_DESC' => $tmp_gmc->ITEM_DESC,
                    'DESTINATION' => $tmp_gmc->DESTINATION,
                    'PLAN_QTY' => 0,
                    'ACTUAL_QTY' => $value->output,
                    'BALANCE_QTY' => $balance,
                    'FORECAST_NAME' => 'WAIT',
                    'ACT_LAST_UPDATE' => $this_time
                ];
                $bulkInsertArray[] = [
                    $tmp_insert['ID'], $tmp_insert['PRODUCT_TYPE'], $tmp_insert['BU'], $tmp_insert['MODEL'], $tmp_insert['PERIOD'], $tmp_insert['ITEM'], $tmp_insert['ITEM_DESC'], $tmp_insert['DESTINATION'], $tmp_insert['PLAN_QTY'], $tmp_insert['ACTUAL_QTY'], $tmp_insert['BALANCE_QTY'], $tmp_insert['FORECAST_NAME'], $tmp_insert['ACT_LAST_UPDATE']
                ];
            }
            /*if (isset($tmp_plan[$index])) {
                $balance = $tmp_plan[$index] - $value->output;
                $tmp_update = IjazahPlanActual::findOne($index);
                $tmp_update->ACTUAL_QTY = $value->output;
                $tmp_update->BALANCE_QTY = $balance;
                $tmp_update->ACT_LAST_UPDATE = $this_time;
                if (!$tmp_update->save()) {
                    return $tmp_update->errors;
                }
                $total_update++;
            } else {
                //$insert_gmc[] = $value->gmc;
                $tmp_gmc = IjazahPlanActual::find()->where(['ITEM' => $value->gmc])->orderBy('PERIOD DESC')->one();
                $balance = 0 - $value->output;
                $tmp_insert = [
                    'ID' => $index,
                    'PRODUCT_TYPE' => $tmp_gmc->PRODUCT_TYPE,
                    'BU' => $tmp_gmc->BU,
                    'MODEL' => $tmp_gmc->MODEL,
                    'PERIOD' => $value->id,
                    'ITEM' => $value->gmc,
                    'ITEM_DESC' => $tmp_gmc->ITEM_DESC,
                    'DESTINATION' => $tmp_gmc->DESTINATION,
                    'PLAN_QTY' => 0,
                    'ACTUAL_QTY' => $value->output,
                    'BALANCE_QTY' => $balance,
                    'FORECAST_NAME' => 'WAIT',
                    'ACT_LAST_UPDATE' => $this_time
                ];
                $bulkInsertArray[] = [
                    $tmp_insert['ID'], $tmp_insert['PRODUCT_TYPE'], $tmp_insert['BU'], $tmp_insert['MODEL'], $tmp_insert['PERIOD'], $tmp_insert['ITEM'], $tmp_insert['ITEM_DESC'], $tmp_insert['DESTINATION'], $tmp_insert['PLAN_QTY'], $tmp_insert['ACTUAL_QTY'], $tmp_insert['BALANCE_QTY'], $tmp_insert['FORECAST_NAME'], $tmp_insert['ACT_LAST_UPDATE']
                ];
            }*/
        }

        $total_insert = count($bulkInsertArray);
        if($total_insert > 0){
            $insertCount = \Yii::$app->db_sql_server->createCommand()
            ->batchInsert(IjazahPlanActual::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
            ->execute();
        }

        //print_r($minus);

        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);
        return [
            'Total Update' => $total_update,
            'Total Insert' => $total_insert,
            'Total Time' => $total_minutes
        ];
    }

    public function actionNgRateInsert()
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tmp_data_arr = [];
        $today = date('Y-m-d');
        $proddate = $today;
        $this_time = date('Y-m-d H:i:s');
        $tmp_serno_input = SernoInput::find()
        ->select([
            'proddate', 'line', 'gmc',
            'total' => 'COUNT(pk)'
        ])
        ->where([
            'proddate' => $proddate
        ])
        ->groupBy('proddate, line, gmc')
        ->all();

        $tmp_ng_fa = ProdNgData::find()
        ->select([
            'post_date', 'gmc_line', 'gmc_no',
            'ng_qty' => 'SUM(ng_qty)'
        ])
        ->where([
            'post_date' => $proddate,
            'loc_id' => 'WF01'
        ])
        ->groupBy('post_date, gmc_line, gmc_no')
        ->all();

        $bulkInsertArray = [];
        $columnNameArray = ['post_date', 'line', 'gmc', 'gmc_desc', 'qty_output', 'qty_ng', 'last_update'];
        $total_count = 0;

        foreach ($tmp_serno_input as $value) {
            $qty_ng = 0;
            foreach ($tmp_ng_fa as $key2 => $value2) {
                if ($value->gmc == $value2->gmc_no && $value->line == $value2->gmc_line) {
                    $qty_ng = $value2->ng_qty;
                }
            }
            $tmp_data_arr[] = [
                'proddate' => $value->proddate,
                'line' => $value->line,
                'gmc' => $value->gmc,
                'qty_output' => $value->total,
                'qty_ng' => $qty_ng
            ];
            $bulkInsertArray[] = [
                $value->proddate, $value->line, $value->gmc, $value->partName, $value->total, $qty_ng, $this_time
            ];
            $total_count++;
        }

        if ($total_count > 0) {
            $insertCount = \Yii::$app->db_sql_server->createCommand()
            ->batchInsert(ProdNgRatio::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
            ->execute();
        }

        return $total_count . ' data inserted';
    }

    public function actionUpdateProdSchedule($today = '')
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tmp_data_arr = [];
        if ($today == '') {
            $today = date('Y-m-d', strtotime('-15 minutes'));
        }
        $last_update = date('Y-m-d H:i:s');

        $tmp_plan = SernoInputPlan::find()
        ->where([
            'plan' => $today
        ])
        ->all();

        $tmp_act = SernoInput::find()
        ->select([
            'gmc',
            'total' => 'COUNT(gmc)'
        ])
        ->where([
            'proddate' => $today
        ])
        ->groupBy('gmc')
        ->all();

        $arr_output = ArrayHelper::map(DailyProductionOutput::find()->where(['proddate' => $today])->all(), 'id', 'id');

        foreach ($tmp_act as $value_act) {
            $is_update = false;
            $pk_plan = '';
            
            foreach ($tmp_plan as $value_plan) {
                if ($value_act->gmc == $value_plan->gmc) {
                    $is_update = true;
                    $pk_plan = $value_plan->pk;
                }
            }
            if ($is_update) {
                $serno_input_plan = SernoInputPlan::find()->where(['pk' => $pk_plan])->one();
                $serno_input_plan->act_qty = $value_act->total;
                $serno_input_plan->balance_qty = $serno_input_plan->act_qty - $serno_input_plan->qty;
                $serno_input_plan->last_update_output = $last_update;
                if (!$serno_input_plan->save()) {
                    return json_encode($serno_input_plan->errors);
                }
            }

            $tmp_pk = $value_act->gmc . date('Ymd', strtotime($today));
            if (!isset($arr_output[$tmp_pk])) {
                $dpo = new DailyProductionOutput;
                $dpo->id = $tmp_pk;
                $dpo->period = date('Ym', strtotime($today));
                $dpo->proddate = $today;
                $dpo->gmc = $value_act->gmc;
            } else {
                $dpo = DailyProductionOutput::findOne($tmp_pk);
            }
            $dpo->last_update = $last_update;
            $dpo->act_qty = $value_act->total;
            if (!$dpo->save()) {
                return json_encode($serno_input_plan->errors);
            }
        }

        return 'Finished ' . $today;
    }

    public function actionDailyProductionUpdateMonthly($period = '')
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($period == '') {
            $period = date('Ym');
        }
        $last_update = date('Y-m-d H:i:s');

        $tmp_act = SernoInputAll::find()
        ->select([
            'proddate', 'gmc',
            'total' => 'COUNT(gmc)'
        ])
        ->where([
            'EXTRACT(year_month FROM proddate)' => $period
        ])
        ->groupBy('proddate, gmc')
        ->all();

        $tmp_output = DailyProductionOutput::find()
        ->where([
            'period' => $period
        ])
        ->all();

        $tmp_plan = SernoInputPlan::find()
        ->where([
            'EXTRACT(year_month FROM plan)' => $period
        ])
        ->all();

        $arr_output = ArrayHelper::map(DailyProductionOutput::find()->where(['period' => $period])->all(), 'id', 'id');

        $bulkInsertArray = array();
        $columnNameArray = ['id', 'period', 'proddate', 'gmc', 'act_qty', 'last_update'];
        foreach ($tmp_plan as $value) {
            if (!isset($arr_output[$value->pk])) {
                $id = $value->pk;
                $period_data = date('Ym', strtotime($value->plan));
                $proddate = date('Y-m-d', strtotime($value->plan));
                $gmc = $value->gmc;
                $act_qty = 0;
                $bulkInsertArray[] = [
                    $id, $period_data, $proddate, $gmc, $act_qty, $last_update
                ];
            }
        }

        if(count($bulkInsertArray) > 0){
            try {
                $insertCount = \Yii::$app->db_mis7->createCommand()
                ->batchInsert(DailyProductionOutput::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
                ->execute();
            } catch (\Exception $e) {
                $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
                return json_encode('error bulk insert' . $e);
            }
        }

        foreach ($tmp_act as $value_act) {
            $output = DailyProductionOutput::find()->where([
                'proddate' => $value_act->proddate,
                'gmc' => $value_act->gmc
            ])->one();
            if (!$output) {
                $output = new DailyProductionOutput;
                $output->id = $value_act->gmc . date('Ymd', strtotime($value_act->proddate));
                $output->period = date('Ym', strtotime($value_act->proddate));
                $output->proddate = $value_act->proddate;
                $output->gmc = $value_act->gmc;
            }
            $output->act_qty = $value_act->total;
            $output->last_update = $last_update;
            if (!$output->save()) {
                return json_encode('error proddate : ' . $value_act->proddate . ', GMC : ' . $value_act->gmc . '. ' . $models->errors);
            }
        }

        return 'Update Success ';
    }

}