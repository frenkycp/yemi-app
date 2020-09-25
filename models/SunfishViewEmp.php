<?php

namespace app\models;

use Yii;
use \app\models\base\SunfishViewEmp as BaseSunfishViewEmp;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.VIEW_YEMI_Emp_OrgUnit".
 */
class SunfishViewEmp extends BaseSunfishViewEmp
{
    public $attend_code, $total_mp;

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

    public static function primaryKey()
    {
        return ["Emp_no"];
    }

    public function getAttendanceData()
    {
        return $this->hasMany(SunfishEmpAttendance::className(), ['emp_no' => 'Emp_no']);
    }

    public function getNikNama()
    {
        return $this->Emp_no . ' - ' . $this->Full_name;
    }
}
