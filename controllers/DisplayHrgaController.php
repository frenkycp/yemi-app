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

class DisplayHrgaController extends Controller
{
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