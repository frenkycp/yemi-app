<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\SunfishAttendanceData;
use app\models\SunfishViewEmp;
use app\models\CarParkAttendance;
use app\models\WorkDayTbl;
use app\models\KoyemiInOutView;
use app\models\Karyawan;
use app\models\PermitInputData;
use app\models\TemperatureDailyView01;
use app\models\TemperatureDailyView02;
use app\models\ScanTemperature;
use app\models\OfficeEmp;

class DisplayHrgaController extends Controller
{

    public function actionTemperatureDailyGetRemark($post_date, $temperature_category)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Temperature Data on ' . date('d M\' Y', strtotime($post_date)) . ' (' . $temperature_category . ')</h3>
        </div>
        <div class="modal-body">
        ';

        $yesterday = date('Y-m-d', strtotime($post_date . ' -1 day'));

        $tmp_attendance = SunfishAttendanceData::instance()->getDailyAttendanceRange($post_date, $post_date);
        $tmp_temperature = TemperatureDailyView02::find()
        ->where([
            '>=', 'POST_DATE', $yesterday
        ])
        ->andWhere([
            '<=', 'POST_DATE', $post_date
        ])
        ->orderBy('TEMPERATURE DESC')->all();
        /*$tmp_temperature = ScanTemperature::find()->where(['POST_DATE' => $post_date])->all();*/

        $shift_summary_arr = [
            1 => [
                'total_check' => 0,
                'total_no_check' => 0
            ],
            2 => [
                'total_check' => 0,
                'total_no_check' => 0
            ],
            3 => [
                'total_check' => 0,
                'total_no_check' => 0
            ],
        ];
        $tmp_data_suspect = $tmp_filter_attendance = $tmp_data_person = $tmp_data = [];
        foreach ($tmp_attendance[$post_date] as $key => $value) {
            if ($value['attend_judgement'] == 'P') {
                $tmp_filter_attendance[] = $value;
            }
        }
        foreach ($tmp_filter_attendance as $attendance_val) {
            $tmp_suhu = $check_time = null;
            foreach ($tmp_temperature as $temp_val) {
                if ($attendance_val['shift'] == 3) {
                    if ($attendance_val['nik'] == $temp_val->NIK && strtotime($temp_val->POST_DATE) == strtotime($yesterday . ' 00:00:00')) {
                        $tmp_suhu = $temp_val->TEMPERATURE;
                        $check_time = $temp_val->LAST_UPDATE;
                        $tmp_suhu_category = $temp_val->TEMPERATURE_CATEGORY;
                    }
                } else {
                    if ($attendance_val['nik'] == $temp_val->NIK && strtotime($temp_val->POST_DATE) == strtotime($post_date . ' 00:00:00')) {
                        $tmp_suhu = $temp_val->TEMPERATURE;
                        $check_time = $temp_val->LAST_UPDATE;
                        $tmp_suhu_category = $temp_val->TEMPERATURE_CATEGORY;
                    }
                }
                
            }
            if ($tmp_suhu == null) {
                $shift_summary_arr[$attendance_val['shift']]['total_no_check'] ++;
            } else {
                $shift_summary_arr[$attendance_val['shift']]['total_check'] ++;
                $tmp_data_person[$tmp_suhu_category . ''][] = [
                    'nik' => $attendance_val['nik'],
                    'name' => $attendance_val['name'],
                    'temperature' => $tmp_suhu,
                    'check_time' => $check_time,
                ];
                /*if ($tmp_suhu >= 37.5) {
                    $tmp_data_suspect[] = [
                        'nik' => $attendance_val['nik'],
                        'name' => $attendance_val['name'],
                        'temperature' => $tmp_suhu,
                    ];
                }
                if ($tmp_suhu < 35) {
                    if (!isset($tmp_data['34'])) {
                        $tmp_data['34'] = 0;
                    }
                    $tmp_data['34']++;
                    $tmp_data_person['34'][] = [
                        'nik' => $attendance_val['nik'],
                        'name' => $attendance_val['name'],
                        'temperature' => $tmp_suhu,
                        'check_time' => $check_time,
                    ];
                } else {
                    if (!isset($tmp_data[$tmp_suhu . ''])) {
                        $tmp_data[$tmp_suhu . ''] = 0;
                    }
                    $tmp_data[$tmp_suhu . '']++;
                    $tmp_data_person[$tmp_suhu . ''][] = [
                        'nik' => $attendance_val['nik'],
                        'name' => $attendance_val['name'],
                        'temperature' => $tmp_suhu,
                        'check_time' => $check_time,
                    ];
                }*/
            }
        }
        
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 14px;">
            <th class="text-center">No.</th>
            <th class="text-center">NIK</th>
            <th class="">Name</th>
            <th class="text-center">Check Time</th>
            <th class="text-center">Temperature</th>
        </tr>';

        $no = 1;
        foreach ($tmp_data_person[$temperature_category . ''] as $key => $value) {
            $remark .= '<tr style="font-size: 14px;">
                <td class="text-center">' . $no . '</td>
                <td class="text-center">' . $value['nik'] . '</td>
                <td class="">' . $value['name'] . '</td>
                <td class="text-center">' . $value['check_time'] . '</td>
                <td class="text-center">' . $value['temperature'] . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    /*public function getEmpTemperature($start_date, $end_date)
    {
        $tmp_scan = ScanTemperature::find()
        ->where([
            'AND',
            ['>=', 'POST_DATE', $start_date],
            ['<=', 'POST_DATE', $end]
        ])
        ->all();

        $tmp_data = [];
        foreach ($tmp_scan as $key => $value) {
            $post_date = date('Y-m-d', strtotime($value->POST_DATE));
            $nik = $value->NIK;
            if (!isset($tmp_data[$post_date][$nik])) {
                $tmp_data[$post_date][$nik] = [
                    'name' => $value->NAMA_KARYAWAN,

                ];
            }
        }
    }*/

    public function actionTemperatureDaily($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'post_date',
        ]);
        $model->addRule(['post_date'], 'required');
        $model->post_date = date('Y-m-d');

        if ($model->load($_GET)) {

        }

        $yesterday = date('Y-m-d', strtotime($model->post_date . ' -1 day'));

        $tmp_attendance = SunfishAttendanceData::instance()->getDailyAttendanceRange($model->post_date, $model->post_date);
        //$color_category_arr = ArrayHelper::map(TemperatureDailyView02::find()->select('TEMPERATURE_CATEGORY, COLOR_CATEGORY')->groupBy('TEMPERATURE_CATEGORY, COLOR_CATEGORY')->all(), 'TEMPERATURE_CATEGORY', 'COLOR_CATEGORY');
        /*$tmp_temperature = TemperatureDailyView01::find()->where([
            '>=', 'POST_DATE', $yesterday
        ])->orderBy('TEMPERATURE')->all();*/
        $tmp_temperature = TemperatureDailyView02::find()
        ->where([
            '>=', 'POST_DATE', $yesterday
        ])
        ->andWhere([
            '<=', 'POST_DATE', $model->post_date
        ])
        ->orderBy('TEMPERATURE')->all();
        /*$tmp_temperature = ScanTemperature::find()->where(['POST_DATE' => $model->post_date])->all();*/

        $shift_summary_arr = [
            1 => [
                'total_check' => 0,
                'total_no_check' => 0
            ],
            2 => [
                'total_check' => 0,
                'total_no_check' => 0
            ],
            3 => [
                'total_check' => 0,
                'total_no_check' => 0
            ],
        ];
        $tmp_data_suspect = $tmp_filter_attendance = $tmp_belum_check = $tmp_data = [];
        $color_category_arr = [];
        foreach ($tmp_attendance[$model->post_date] as $key => $value) {
            if ($value['attend_judgement'] == 'P') {
                $tmp_filter_attendance[] = $value;
            }
        }
        foreach ($tmp_filter_attendance as $attendance_val) {
            $tmp_suhu = null;
            foreach ($tmp_temperature as $temp_val) {
                $color_category_arr[$temp_val->TEMPERATURE_CATEGORY] = $temp_val->COLOR_CATEGORY;
                if ($attendance_val['shift'] == 3) {
                    if ($attendance_val['nik'] == $temp_val->NIK && strtotime($temp_val->POST_DATE) == strtotime($yesterday . ' 00:00:00')) {
                        $tmp_suhu = $temp_val->TEMPERATURE;
                        $tmp_suhu_category = $temp_val->TEMPERATURE_CATEGORY;
                    }
                } else {
                    if ($attendance_val['nik'] == $temp_val->NIK && strtotime($temp_val->POST_DATE) == strtotime($model->post_date . ' 00:00:00')) {
                        $tmp_suhu = $temp_val->TEMPERATURE;
                        $tmp_suhu_category = $temp_val->TEMPERATURE_CATEGORY;
                    }
                }
                
            }
            if ($tmp_suhu == null) {
                $shift_summary_arr[$attendance_val['shift']]['total_no_check'] ++;
                $attend_judgement = $attendance_val['attend_judgement'];
                $attend_judgement_txt = '-';
                if ($attend_judgement == 'P') {
                    $attend_judgement_txt = 'Hadir';
                } elseif ($attend_judgement == 'A') {
                    $attend_judgement_txt = 'Alpa';
                } elseif ($attend_judgement == 'I') {
                    $attend_judgement_txt = 'Ijin';
                } elseif ($attend_judgement == 'S') {
                    $attend_judgement_txt = 'Sakit';
                } elseif ($attend_judgement == 'C') {
                    $attend_judgement_txt = 'Cuti';
                }
                $tmp_belum_check[$attendance_val['shift']][] = [
                    'nik' => $attendance_val['nik'],
                    'name' => $attendance_val['name'],
                    'shift' => 'Shift_' . $attendance_val['shift'],
                    'attendance' => $attend_judgement_txt,
                ];
            } else {
                $shift_summary_arr[$attendance_val['shift']]['total_check'] ++;
                if ($tmp_suhu >= 37.5) {
                    $tmp_data_suspect[] = [
                        'nik' => $attendance_val['nik'],
                        'name' => $attendance_val['name'],
                        'temperature' => $tmp_suhu,
                    ];
                }
                if (!isset($tmp_data[$tmp_suhu_category . ''])) {
                    $tmp_data[$tmp_suhu_category . ''] = 0;
                }
                $tmp_data[$tmp_suhu_category . '']++;
                /*if ($tmp_suhu < 35) {
                    if (!isset($tmp_data['34'])) {
                        $tmp_data['34'] = 0;
                    }
                    $tmp_data['34']++;
                } else {
                    if (!isset($tmp_data[$tmp_suhu . ''])) {
                        $tmp_data[$tmp_suhu . ''] = 0;
                    }
                    $tmp_data[$tmp_suhu . '']++;
                }*/
            }
        }

        if (count($tmp_data) > 0) {
            ksort($tmp_data);
        }

        if (count($tmp_belum_check) > 0) {
            ksort($tmp_belum_check);
        }

        $data_chart = $categories = $tmp_data_chart = [];
        foreach ($tmp_data as $key => $value) {
            /*$category = $key . ' °C';
            if ($key == '34') {
                $category = '<35 °C';
            }*/
            $tmp_color = $color_category_arr[$key];
            $color_name = strtolower($tmp_color);
            $categories[] = $key;
            $tmp_data_chart[] = [
                //'x' => $category,
                'y' => $value,
                'url' => Url::to(['temperature-daily-get-remark', 'post_date' => $model->post_date, 'temperature_category' => $key]),
                'color' => $color_name,
                'dataLabels' => [
                    'color' => $color_name == 'red' ? 'red' : 'white',
                ],
            ];
        }
        $data_chart = [
            [
                'name' => 'Total Person(s)',
                'data' => $tmp_data_chart,
                'showInLegend' => false,
            ],
        ];

        return $this->render('temperature-daily', [
            'model' => $model,
            'categories' => $categories,
            'data_chart' => $data_chart,
            'tmp_attendance' => $tmp_attendance,
            'shift_summary_arr' => $shift_summary_arr,
            'tmp_data_suspect' => $tmp_data_suspect,
            'tmp_data' => $tmp_data,
            'tmp_belum_check' => $tmp_belum_check,
        ]);
    }

    public function actionOfficeBodyTemp($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'post_date',
        ]);
        $model->addRule(['post_date'], 'required');
        $model->post_date = date('Y-m-d');

        if ($model->load($_GET)) {

        }

        $yesterday = date('Y-m-d', strtotime($model->post_date . ' -1 day'));

        $tmp_attendance = SunfishAttendanceData::instance()->getDailyAttendanceRange($model->post_date, $model->post_date);
        $tmp_office_emp = OfficeEmp::find()->all();
        $today_temp = ScanTemperature::find()->where(['POST_DATE' => $model->post_date])->orderBy('LAST_UPDATE')->all();
        $yesterday_temp = ScanTemperature::find()->where(['POST_DATE' => $yesterday])->orderBy('LAST_UPDATE')->all();

        $total_check = $total_no_check = 0;
        $no_check_data = $temp_over_data = [];
        $temp_category_total = [
            '34 - 34.9' => [],
            '35 - 35.4' => [],
            '35.5 - 35.9' => [],
            '36 - 36.4' => [],
            '36.5 - 36.9' => [],
            '37 - 37.4' => [],
            '≥ 37.5' => [],
        ];
        foreach ($tmp_attendance[$model->post_date] as $attendance_val) {
            $attend_judgement = $attendance_val['attend_judgement'];
            $emp_shift = $attendance_val['shift'];
            $emp_name = $attendance_val['name'];

            if ($emp_shift == 3) {
                $temp_data = $yesterday_temp;
            } else {
                $temp_data = $today_temp;
            }

            $body_temp = 0;
            $last_update = null;
            foreach ($temp_data as $temp_value) {
                if ($temp_value->NIK == $attendance_val['nik']) {
                    $body_temp = $temp_value->SUHU;
                    $last_update = $temp_value->LAST_UPDATE;
                }
            }

            if ($last_update == null) {
                if ($attend_judgement == 'P') {
                    $attend_judgement_txt = 'Hadir';
                } elseif ($attend_judgement == 'I') {
                    $attend_judgement_txt = 'Ijin';
                } elseif ($attend_judgement == 'S') {
                    $attend_judgement_txt = 'Sakit';
                } elseif ($attend_judgement == 'C') {
                    $attend_judgement_txt = 'Cuti';
                } else {
                    $attend_judgement_txt = 'Alpa';
                }
                $no_check_data[] = [
                    'nik' => $attendance_val['nik'],
                    'name' => $emp_name,
                    'attendance' => $attend_judgement_txt
                ];
                $total_no_check++;
            } else {
                $total_check++;
                if ($body_temp >= 37.5) {
                    $temp_over_data[] = [
                        'nik' => $attendance_val['nik'],
                        'name' => $emp_name,
                        'temperature' => $body_temp
                    ];
                }

                $tmp_category_data = [
                    'nik' => $attendance_val['nik'],
                    'name' => $emp_name,
                    'temperature' => $body_temp,
                    'last_update' => $last_update,
                ];

                if ($body_temp < 35) {
                    $temp_category_total['34 - 34.9'][] = $tmp_category_data;
                } elseif ($body_temp < 35.5) {
                    $temp_category_total['35 - 35.4'][] = $tmp_category_data;
                } elseif ($body_temp < 36) {
                    $temp_category_total['35.5 - 35.9'][] = $tmp_category_data;
                } elseif ($body_temp < 36.5) {
                    $temp_category_total['36 - 36.4'][] = $tmp_category_data;
                } elseif ($body_temp < 37) {
                    $temp_category_total['36.5 - 36.9'][] = $tmp_category_data;
                } elseif ($body_temp < 37.5) {
                    $temp_category_total['37 - 37.4'][] = $tmp_category_data;
                } else {
                    $temp_category_total['≥ 37.5'][] = $tmp_category_data;
                }
            }
        }

        $data_chart = $categories = $tmp_data_chart = [];
        foreach ($temp_category_total as $key => $value) {
            $categories[] = $key;

            if ($key == '≥ 37.5') {
                $color_name = 'red';
            } else {
                $color_name = 'green';
            }

            $remark = '<div style="padding: 5px;">
            <table class="table table-bordered table-striped table-hover" style="margin-bottom: 0px;">';
            $remark .= 
            '<tr>
                <th class="text-center">#</th>
                <th class="text-center">NIK</th>
                <th class="text-center">Name</th>
                <th class="text-center">Check Time</th>
                <th class="text-center">Temp.</th>
            </tr>'
            ;

            $no = 0;
            foreach ($value as $value2) {
                $no++;
                $remark .= '<tr>
                    <td class="text-center">' . $no . '</td>
                    <td class="text-center">' . $value2['nik'] . '</td>
                    <td class="text-center">' . $value2['name'] . '</td>
                    <td class="text-center">' . date('d M\' Y H:i', strtotime($value2['last_update'])) . '</td>
                    <td class="text-center">' . $value2['temperature'] . '</td>
                </tr>';
            }

            $remark .= '</table></div>';

            $tmp_data_chart[] = [
                //'x' => $category,
                'y' => count($value),
                'remark' => $remark,
                //'url' => Url::to(['temperature-daily-get-remark', 'post_date' => $model->post_date, 'temperature_category' => $key]),
                'color' => $color_name,
                'dataLabels' => [
                    'color' => $color_name == 'red' ? 'red' : 'white',
                ],
            ];
        }

        $no_check_data2 = [
            'Hadir' => [],
            'Sakit' => [],
            'Ijin' => [],
            'Alpa' => [],
            'Cuti' => [],
        ];

        foreach ($no_check_data as $value) {
            $no_check_data2[$value['attendance']][] = $value;
        }

        $data_chart = [
            [
                'name' => 'Total Person(s)',
                'data' => $tmp_data_chart,
                'showInLegend' => false,
            ],
        ];

        return $this->render('office-body-temp', [
            'model' => $model,
            'total_check' => $total_check,
            'total_no_check' => $total_no_check,
            'no_check_data' => $no_check_data,
            'no_check_data2' => $no_check_data2,
            'temp_over_data' => $temp_over_data,
            'categories' => $categories,
            'data_chart' => $data_chart,
        ]);
    }

    public function actionTopPermitData($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');

        $model->period = date('Ym');

        if ($model->load($_GET)) {

        }

        $data = PermitInputData::find()
        ->select([
            'period' => 'extract(year_month FROM tgl)', 'nik', 'nama',
            'total' => 'COUNT(id)'
        ])
        ->where([
            'extract(year_month FROM tgl)' => $model->period,
            'handleby' => 'pribadi'
        ])
        ->groupBy(['extract(year_month FROM tgl)', 'nik', 'nama'])
        ->orderBy('total DESC')
        ->limit(20)
        ->all();

        return $this->render('top-permit-data', [
            'data' => $data,
            'model' => $model,
        ]);
    }

    public function actionKoyemiMaxCapacityData($max_capacity='')
    {
        date_default_timezone_set('Asia/Jakarta');

        $tmp_in_out = KoyemiInOutView::find()
        ->where([
            'in_out_status' => 'KANTIN IN',
        ])
        ->andWhere(['>', 'in_out_datetime', date('Y-m-d H:i:s', strtotime('-2 minutes'))])
        ->orderBy('in_out_datetime')
        ->all();

        $tmp_nik_arr = $tmp_data_pengunjung = [];
        foreach ($tmp_in_out as $key => $value) {
            $nik = $value->user_name;
            $tmp_nik_arr[] = $nik;
            $tmp_data_pengunjung[$nik] = [
                'in' => date('H:i', strtotime($value->in_out_datetime))
            ];
        }
        $tmp_data_karyawan = ArrayHelper::map(Karyawan::find()->where(['NIK_SUN_FISH' => $tmp_nik_arr])->all(), 'NIK_SUN_FISH', 'NAMA_KARYAWAN');
        //$tmp_data_karyawan = [];
        foreach ($tmp_data_pengunjung as $key => $value) {
            if (isset($tmp_data_karyawan[$key])) {
                $tmp_data_pengunjung[$key]['full_name'] = $tmp_data_karyawan[$key];
            } else {
                $tmp_data_pengunjung[$key]['full_name'] = $key;
            }
            
        }
        $current_capacity = count($tmp_data_pengunjung);
        //$current_capacity = 6;
        if ($current_capacity >= $max_capacity) {
            $msg = 'TUNGGU DULU';
            $img_url = Url::to('@web/uploads/ICON/NO-2.png');
            $bg_class = 'bg-red';
        } else {
            $msg = 'BOLEH MASUK';
            $img_url = Url::to('@web/uploads/ICON/YES.png');
            $bg_class = 'bg-green';
        }

        $data = [
            'current_capacity' => $current_capacity,
            'msg' => $msg,
            'bg_class' => $bg_class,
            'img_url' => $img_url,
            'detail_pembeli' => $tmp_data_pengunjung
        ];
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function actionKoyemiMaxCapacity($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $max_capacity = 5;

        $tmp_in_out = KoyemiInOutView::find()
        ->where([
            'in_out_status' => 'KANTIN IN',
        ])
        ->andWhere(['>', 'in_out_datetime', date('Y-m-d H:i:s', strtotime('-2 minutes'))])
        ->orderBy('in_out_datetime')
        ->all();

        $tmp_nik_arr = $tmp_data_pengunjung = [];
        foreach ($tmp_in_out as $key => $value) {
            $nik = $value->user_name;
            $tmp_nik_arr[] = $nik;
            $tmp_data_pengunjung[$nik] = [
                'in' => date('H:i', strtotime($value->in_out_datetime))
            ];
        }
        $tmp_data_karyawan = ArrayHelper::map(Karyawan::find()->where(['NIK_SUN_FISH' => $tmp_nik_arr])->all(), 'NIK_SUN_FISH', 'NAMA_KARYAWAN');
        //$tmp_data_karyawan = [];
        foreach ($tmp_data_pengunjung as $key => $value) {
            if (isset($tmp_data_karyawan[$key])) {
                $tmp_data_pengunjung[$key]['full_name'] = $tmp_data_karyawan[$key];
            } else {
                $tmp_data_pengunjung[$key]['full_name'] = $key;
            }
        }
        $current_capacity = count($tmp_data_pengunjung);
        if ($current_capacity >= $max_capacity) {
            $msg = 'TUNGGU DULU';
            $img_url = Url::to('@web/uploads/ICON/NO-2.png');
            $bg_class = 'bg-red';
        } else {
            $msg = 'BOLEH MASUK';
            $img_url = Url::to('@web/uploads/ICON/YES.png');
            $bg_class = 'bg-green';
        }

        $data = [
            'current_capacity' => $current_capacity,
            'msg' => $msg,
            'bg_class' => $bg_class,
            'img_url' => $img_url,
            'detail_pembeli' => $tmp_data_pengunjung
        ];

        return $this->render('koyemi-max-capacity', [
            'max_capacity' => $max_capacity,
            'data' => $data,
        ]);
    }

    public function actionProgressOvertimeHours($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');

        $model->period = date('Ym');

        if ($model->load($_GET)) {

        }

        /*$data2 = SunfishAttendanceData::instance()->getDailyAttendanceRange('2020-09-01', '2020-09-24');
        $data_arr = [];
        foreach ($data2 as $key => $value) {
            $data_arr[] = count($value);
        }
        return json_encode($data2);*/

        $tmp_attendance = SunfishAttendanceData::find()
        ->select([
            'cost_center', 'total_ot' => 'SUM(total_ot)'
        ])
        ->where([
            'FORMAT(shiftendtime, \'yyyyMM\')' => $model->period
        ])
        ->andWhere('total_ot IS NOT NULL')
        ->andWhere(['NOT IN', 'cost_center', ['Board of Director']])
        ->groupBy('cost_center')
        ->orderBy('cost_center')
        ->all();

        $mp_by_section = SunfishViewEmp::find()
        ->select([
            'cost_center_name', 'total_mp' => 'COUNT(*)'
        ])
        ->where(['status' => 1])
        ->andWhere('cost_center_code NOT IN (\'10\', \'110X\') AND PATINDEX(\'YE%\', Emp_no) > 0')
        ->groupBy('cost_center_name')
        ->orderBy('cost_center_name')
        ->all();

        $data = [];
        $grand_total_mp = 0;
        foreach ($mp_by_section as $mp) {
            $tmp_total_ot = 0;
            $grand_total_mp += $mp->total_mp;
            foreach ($tmp_attendance as $attendance) {
                if ($attendance->cost_center == $mp->cost_center_name) {
                    $tmp_total_ot = $attendance->total_ot;
                }
            }
            //if ($tmp_total_ot > 0) {
                $data[$mp->cost_center_name] = [
                    'total_ot' => $tmp_total_ot,
                    'total_mp' => $mp->total_mp
                ];
            //}
            
        }

        $tmp_top_ten = SunfishAttendanceData::find()
        ->select([
            'emp_no', 'full_name', 'cost_center', 'total_ot' => 'SUM(total_ot)'
        ])
        ->where('total_ot IS NOT NULL AND PATINDEX(\'YE%\', emp_no) > 0')
        ->andWhere([
            'FORMAT(shiftendtime, \'yyyyMM\')' => $model->period
        ])
        ->groupBy('emp_no, full_name, cost_center')
        ->orderBy('SUM(total_ot) DESC')
        ->limit(10)->asArray()->all();

        return $this->render('progress-overtime-hours', [
            'data' => $data,
            'grand_total_mp' => $grand_total_mp,
            'model' => $model,
            'tmp_attendance' => $tmp_attendance,
            'total_mp' => $total_mp,
            'tmp_top_ten' => $tmp_top_ten,
        ]);
    }

    public function actionCarParkUsageGetRemark($period, $emp_id, $emp_name, $working_days, $usage)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $emp_name . ' - ' . $emp_id . ' <small>(Period : ' . $period . ', Total Working Day : ' . $working_days . ', Usage : ' . $usage . ')</small></h3>
        </div>
        <div class="modal-body">
        ';

        $tmp_work_day = WorkDayTbl::find()
        ->select(['cal_date' => 'FORMAT(cal_date, \'yyyy-MM-dd\')'])
        ->where([
            'FORMAT(cal_date, \'yyyyMM\')' => $period
        ])
        ->andWhere('holiday IS NULL')
        ->all();

        $work_day_arr = [];
        foreach ($tmp_work_day as $key => $value) {
            $work_day_arr[] = $value->cal_date;
        }

        $tmp_park_attendance = CarParkAttendance::find()
        ->where([
            'emp_id' => $emp_id,
            'period' => $period,
            'post_date' => $work_day_arr
        ])
        ->orderBy('post_date')
        ->all();
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 14px;">
            <th class="text-center">No.</th>
            <th class="text-center">Date</th>
            <th class="text-center">RFID Scan Status</th>
            <th class="text-center">Parking Status</th>
            <th class="text-center">In Datetime</th>
            <th class="text-center">Out Datetime</th>
            <th class="text-center">Trip Category</th>
        </tr>';

        $no = 1;
        foreach ($tmp_park_attendance as $key => $value) {
            if ($value->rfid_scan_status == 1) {
                $rfid_scan_status = 'O';
            } else {
                $rfid_scan_status = 'X';
            }
            if ($value->parking_status == 1) {
                $parking_status = 'O';
                $tmp_class = ' success';
            } else {
                $parking_status = 'X';
                $tmp_class = ' danger';
            }

            $in_datetime = $value->in_datetime == null ? '-' : date('Y-m-d H:i', strtotime($value->in_datetime));
            $out_datetime = $value->out_datetime == null ? '-' : date('Y-m-d H:i', strtotime($value->out_datetime));
            $remark .= '<tr style="font-size: 14px;">
                <td class="text-center' . $tmp_class . '">' . $no . '</td>
                <td class="text-center' . $tmp_class . '">' . $value->post_date . '</td>
                <td class="text-center' . $tmp_class . '">' . $rfid_scan_status . '</td>
                <td class="text-center' . $tmp_class . '">' . $parking_status . '</td>
                <td class="text-center' . $tmp_class . '">' . $in_datetime . '</td>
                <td class="text-center' . $tmp_class . '">' . $out_datetime . '</td>
                <td class="text-center' . $tmp_class . '">' . $value->trip_category . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }
    public function actionCarParkUsage($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'period', 'account_type'
        ]);
        $model->addRule(['period', 'account_type'], 'required');

        $model->period = date('Ym');
        $model->account_type = 'COORDINATOR';

        if ($model->load($_GET)) {

        }

        $tmp_work_day = WorkDayTbl::find()
        ->select(['cal_date' => 'FORMAT(cal_date, \'yyyy-MM-dd\')'])
        ->where([
            'FORMAT(cal_date, \'yyyyMM\')' => $model->period
        ])
        ->andWhere('holiday IS NULL')
        ->all();

        $work_day_arr = [];
        foreach ($tmp_work_day as $key => $value) {
            $work_day_arr[] = $value->cal_date;
        }

        $working_days = count($work_day_arr);

        $tmp_attendance = CarParkAttendance::find()
        ->select([
            'emp_id', 'emp_name', 'total_usage' => 'SUM(parking_status)'
        ])
        ->where([
            'period' => $model->period,
            'account_type' => $model->account_type,
            'post_date' => $work_day_arr
        ])
        ->andWhere(['<>', 'emp_id', 'YE9909002'])
        ->groupBy('emp_id, emp_name')
        ->orderBy('total_usage DESC, emp_name')
        ->all();

        $categories = $tmp_data = $data = [];
        foreach ($tmp_attendance as $key => $value) {
            $categories[] = $value->emp_name . ' - ' . $value->emp_id;
            $pct = 0;
            if ($working_days > 0) {
                $pct = round(($value->total_usage / $working_days) * 100, 1);
            }
            $tmp_data[] = [
                'y' => $pct,
                'url' => Url::to(['car-park-usage-get-remark', 'period' => $model->period, 'emp_id' => $value->emp_id, 'emp_name' => $value->emp_name, 'working_days' => $working_days, 'usage' => $value->total_usage])
            ];
        }

        $data = [
            [
                'name' => 'Usage Percentage',
                'data' => $tmp_data,
                'showInLegend' => false,
            ],
        ];

        return $this->render('car-park-usage', [
            'data' => $data,
            'categories' => $categories,
            'model' => $model,
        ]);
    }

    public function actionDailyOvertimeByDept($type = 'hour')
    {
         $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        $tmp_department_arr = SunfishViewEmp::find()->select('Department')->where('Department IS NOT NULL')->groupBy('Department')->orderBy('Department')->all();

        $tmp_attendance_arr = SunfishAttendanceData::find()
        ->select([
            'department' => 'VIEW_YEMI_Emp_OrgUnit.Department',
            'post_date' => 'FORMAT(shiftendtime, \'yyyy-MM-dd\')',
            'total_ot' => 'SUM(total_ot)',
            'total_mp' => 'COUNT(*)'
        ])
        ->leftJoin('VIEW_YEMI_Emp_OrgUnit', 'VIEW_YEMI_Emp_OrgUnit.Emp_no = VIEW_YEMI_ATTENDANCE.emp_no')
        ->where([
            'AND',
            ['>=', 'shiftendtime', $model->from_date],
            ['<=', 'shiftendtime', $model->to_date]
        ])
        ->andWhere('total_ot IS NOT NULL')
        ->groupBy(['VIEW_YEMI_Emp_OrgUnit.Department', 'FORMAT(shiftendtime, \'yyyy-MM-dd\')'])
        ->orderBy('post_date')
        ->all();

        $tmp_data = $data = $tmp_data2 = $data2 = [];
        $total_hour = $total_mp = 0;
        foreach ($tmp_attendance_arr as $key => $attendance) {
            $post_date = (strtotime($attendance->post_date . " +7 hours") * 1000);
            $total_hour += round(($attendance->total_ot / 60), 1);
            $total_mp += $attendance->total_mp;
            $tmp_data[$attendance->department][] = [
                'x' => $post_date,
                'y' => round(($attendance->total_ot / 60), 1)
            ];
            $tmp_data2[$attendance->department][] = [
                'x' => $post_date,
                'y' => (int)$attendance->total_mp
            ];
        }

        foreach ($tmp_department_arr as $attendance) {
            if (isset($tmp_data[$attendance->Department])) {
                $data[] = [
                    'name' => $attendance->Department,
                    'data' => $tmp_data[$attendance->Department]
                ];
            } else {
                $data[] = [
                    'name' => $attendance->Department,
                    'data' => []
                ];
            }

            if (isset($tmp_data2[$attendance->Department])) {
                $data2[] = [
                    'name' => $attendance->Department,
                    'data' => $tmp_data2[$attendance->Department]
                ];
            } else {
                $data2[] = [
                    'name' => $attendance->Department,
                    'data' => []
                ];
            }
        }

        /*$begin = new \DateTime(date('Y-m-d', strtotime($model->from_date)));
        $end   = new \DateTime(date('Y-m-d', strtotime($model->to_date)));

        foreach ($tmp_department_arr as $department) {
            $tmp_data[$department] = [];
            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $tgl = $i->format("Y-m-d");
                $post_date = (strtotime($tgl . " +7 hours") * 1000);
                foreach ($tmp_attendance_arr as $attendance) {
                    # code...
                }
            }
        }*/

        return $this->render('daily-overtime-by-dept', [
            'model' => $model,
            'data' => $data,
            'data2' => $data2,
            'type' => $type,
            'total_hour' => $total_hour,
            'total_mp' => $total_mp,
        ]);
    }
}