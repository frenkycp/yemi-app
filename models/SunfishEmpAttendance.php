<?php

namespace app\models;

use Yii;
use \app\models\base\SunfishEmpAttendance as BaseSunfishEmpAttendance;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.VIEW_YEMI_Emp_Attendance".
 */
class SunfishEmpAttendance extends BaseSunfishEmpAttendance
{
    public $post_date, $period, $name, $shift_filter, $present, $total_absent, $total_present, $total_permit, $total_sick, $total_cuti, $total_late, $total_early_out,
    $total_shift1, $total_shift2, $total_shift3, $total_shift4, $total_no_shift,
    $shift1_hadir, $shift2_hadir, $shift3_hadir, $shift4_hadir, $no_shift_hadir,
    $shift1_cuti, $shift2_cuti, $shift3_cuti, $shift4_cuti, $no_shift_cuti,
    $shift1_ijin, $shift2_ijin, $shift3_ijin, $shift4_ijin, $no_shift_ijin,
    $shift1_alpa, $shift2_alpa, $shift3_alpa, $shift4_alpa, $no_shift_alpa,
    $shift1_sakit, $shift2_sakit, $shift3_sakit, $shift4_sakit, $no_shift_sakit,
    $total_ck_no_disiplin, $total_ck;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function getEmpData()
    {
        return $this->hasOne(SunfishViewEmp::className(), ['Emp_no' => 'emp_no']);
    }

    public static function primaryKey()
    {
        return ['emp_no'];
    }

    public function getPresent()
    {
        $code = $this->Attend_Code;
        if (strpos($code, 'PRS')) {
            return 'Y';
        } else {
            return 'N';
        }
    }

    public function getTotalMp($post_date)
    {
        $tmp_model = $this::find()->select([
            'total_shift1' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) > 0 THEN 1 ELSE 0 END)',
            'total_shift2' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 THEN 1 ELSE 0 END)',
            'total_shift3' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0 THEN 1 ELSE 0 END)',
            'total_no_shift' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) = 0 THEN 1 ELSE 0 END)',
            'shift1_hadir' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'shift2_hadir' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'shift3_hadir' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'no_shift_hadir' => 'SUM(CASE WHEN (PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) = 0) AND PATINDEX(\'%PRS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'shift1_cuti' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) > 0 AND ((PATINDEX(\'%CUTI%\', Attend_Code) > 0 OR PATINDEX(\'%CK%\', Attend_Code) > 0) AND PATINDEX(\'%PRS%\', Attend_Code) = 0 AND PATINDEX(\'%Izin%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'shift2_cuti' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 AND ((PATINDEX(\'%CUTI%\', Attend_Code) > 0 OR PATINDEX(\'%CK%\', Attend_Code) > 0) AND PATINDEX(\'%PRS%\', Attend_Code) = 0 AND PATINDEX(\'%Izin%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'shift3_cuti' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0 AND ((PATINDEX(\'%CUTI%\', Attend_Code) > 0 OR PATINDEX(\'%CK%\', Attend_Code) > 0) AND PATINDEX(\'%PRS%\', Attend_Code) = 0 AND PATINDEX(\'%Izin%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'no_shift_cuti' => 'SUM(CASE WHEN (PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) = 0) AND ((PATINDEX(\'%CUTI%\', Attend_Code) > 0 OR PATINDEX(\'%CK%\', Attend_Code) > 0) AND PATINDEX(\'%PRS%\', Attend_Code) = 0 AND PATINDEX(\'%Izin%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'shift1_ijin' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) > 0 AND (PATINDEX(\'%Izin%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'shift2_ijin' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 AND (PATINDEX(\'%Izin%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'shift3_ijin' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0 AND (PATINDEX(\'%Izin%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'no_shift_ijin' => 'SUM(CASE WHEN (PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) = 0) AND (PATINDEX(\'%Izin%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'shift1_alpa' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) > 0 AND PATINDEX(\'%ABS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'shift2_alpa' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 AND PATINDEX(\'%ABS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'shift3_alpa' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0 AND PATINDEX(\'%ABS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'no_shift_alpa' => 'SUM(CASE WHEN (PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) = 0) AND PATINDEX(\'%ABS%\', Attend_Code) > 0 THEN 1 ELSE 0 END)',
            'shift1_sakit' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) > 0 AND (PATINDEX(\'%SAKIT%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'shift2_sakit' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) > 0 AND (PATINDEX(\'%SAKIT%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'shift3_sakit' => 'SUM(CASE WHEN PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) > 0 AND (PATINDEX(\'%SAKIT%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
            'no_shift_sakit' => 'SUM(CASE WHEN (PATINDEX(\'%SHIFT_1%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_2%\', UPPER(shiftdaily_code)) = 0 AND PATINDEX(\'%SHIFT_3%\', UPPER(shiftdaily_code)) = 0) AND (PATINDEX(\'%SAKIT%\', Attend_Code) > 0 AND PATINDEX(\'%PRS%\', Attend_Code) = 0) THEN 1 ELSE 0 END)',
        ])
        ->leftJoin('VIEW_YEMI_Emp_OrgUnit', 'VIEW_YEMI_Emp_Attendance.emp_no = VIEW_YEMI_Emp_OrgUnit.Emp_no')
        ->where([
            //'status' => 1,
            'FORMAT(shiftendtime, \'yyyy-MM-dd\')' => $post_date
        ])
        ->andWhere('PATINDEX(\'M%\', grade_code) = 0 AND PATINDEX(\'D%\', grade_code) = 0 AND cost_center_code NOT IN (\'10\', \'110X\', \'110D\')')
        ->asArray()->one();

        return $tmp_model;
    }
}
