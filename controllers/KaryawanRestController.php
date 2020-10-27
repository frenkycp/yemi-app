<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\Karyawan;
use app\models\SunfishAttendanceData;

class KaryawanRestController extends Controller
{
    public function actionGetInfo($nik = '')
    {
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($nik == '') {
            $tmp_karyawan = Karyawan::find()
            ->select(['NIK', 'NIK_SUN_FISH', 'NAMA_KARYAWAN', 'DEPARTEMEN', 'SECTION', 'CC_ID'])
            ->where(['AKTIF' => 'Y'])
            ->all();
        } else {
            $tmp_karyawan = Karyawan::find()
            ->select(['NIK', 'NIK_SUN_FISH', 'NAMA_KARYAWAN', 'DEPARTEMEN', 'SECTION', 'CC_ID'])
            ->where(['OR', ['NIK_SUN_FISH' => $nik], ['NIK' => $nik]])->one();
        }
    	

    	if (!$tmp_karyawan) {
    		return 'NIK not found';
    	}

    	return $tmp_karyawan;
    }

    public function actionSunfishAttendance($from_date = '', $to_date = '')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($from_date == '' || $to_date == '') {
            $from_date = date('Y-m-01');
            $to_date = date('Y-m-d');
        }

        $tmp_attendance = SunfishAttendanceData::find()
        ->select([
            'post_date' => 'CAST(shiftendtime AS DATE)', 'VIEW_YEMI_ATTENDANCE.emp_no', 'VIEW_YEMI_ATTENDANCE.full_name', 'cost_center', 'grade' => 'VIEW_YEMI_Emp_OrgUnit.grade_code', 'attend_judgement', 'starttime', 'endtime'
        ])
        ->leftJoin('VIEW_YEMI_Emp_OrgUnit', 'VIEW_YEMI_Emp_OrgUnit.Emp_no = VIEW_YEMI_ATTENDANCE.emp_no')
        ->where('PATINDEX(\'YE%\', VIEW_YEMI_ATTENDANCE.emp_no) > 0 AND cost_center NOT IN (\'Expatriate\') AND shiftdaily_code <> \'OFF\'')
        ->andWhere([
            'AND',
            ['>=', 'FORMAT(shiftendtime, \'yyyy-MM-dd\')', $from_date],
            ['<=', 'FORMAT(shiftendtime, \'yyyy-MM-dd\')', $to_date]
        ])
        ->orderBy('shiftendtime, cost_center, emp_no')
        ->asArray()
        ->all();

        return $tmp_attendance;
    }
}