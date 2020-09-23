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

class DisplayHrgaController extends Controller
{
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

        $tmp_attendance = CarParkAttendance::find()
        ->select([
            'emp_id', 'emp_name', 'total_usage' => 'SUM(parking_status)'
        ])
        ->where([
            'period' => $model->period,
            'account_type' => $model->account_type
        ])
        ->groupBy('emp_id, emp_name')
        ->orderBy('total_usage DESC')
        ->all();

        return $this->render('car-park-usage', [
            'data' => $data,
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
        foreach ($tmp_attendance_arr as $key => $attendance) {
            $post_date = (strtotime($attendance->post_date . " +7 hours") * 1000);
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
        ]);
    }
}