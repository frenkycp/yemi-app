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

class DisplayHrgaController extends Controller
{
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
            'bsevtdt' => date('Y-m-d')
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
            'bsevtdt' => date('Y-m-d')
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