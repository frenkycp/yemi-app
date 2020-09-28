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

    public function getMpByScetion()
    {
        $tmp_data = $this::find()
        ->select([
            'cost_center_name', 'total_mp' => 'COUNT(*)'
        ])
        ->where(['status' => 1])
        ->andWhere('cost_center_code NOT IN (\'10\', \'110X\') AND PATINDEX(\'YE%\', Emp_no) > 0')
        ->groupBy('cost_center_name')
        ->orderBy('cost_center_name')
        ->asArray()
        ->all();

        return $tmp_data;
    }

    public function getSectionDropdown($value='')
    {
        $tmp_dropdown = ArrayHelper::map($this::find()
        ->select([
            'cost_center_name'
        ])
        ->where('cost_center_code NOT IN (\'10\', \'110X\') AND PATINDEX(\'YE%\', Emp_no) > 0')
        ->groupBy('cost_center_name')
        ->orderBy('cost_center_name')
        ->all(), 'cost_center_name', 'cost_center_name');

        return $tmp_dropdown;
    }
}
