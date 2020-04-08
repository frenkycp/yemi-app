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
    public $post_date, $period, $name, $shift_filter, $present, $total_absent, $total_present, $total_permit, $total_sick, $total_cuti, $total_late, $total_early_out, $total_shift1, $total_shift2, $total_shift3, $total_shift4, $total_ck_no_disiplin, $total_ck;

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

    public function getPresent()
    {
        $code = $this->Attend_Code;
        if (strpos($code, 'PRS')) {
            return 'Y';
        } else {
            return 'N';
        }
    }
}
