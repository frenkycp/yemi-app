<?php

namespace app\models;

use Yii;
use \app\models\base\MntShiftSch as BaseMntShiftSch;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.mnt_shift_sch".
 */
class MntShiftSch extends BaseMntShiftSch
{
    public $emp_name;

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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'id' => 'ID',
                'shift_emp_id' => 'Shift Emp ID',
                'period' => 'Period',
                'shift_date' => 'Shift Date',
                'shift_code' => 'Shift Code',
            ]
        );
    }

    public function getMntShiftEmp()
    {
        return $this->hasOne(MntShiftEmp::className(), ['id' => 'shift_emp_id']);
    }

    public function getMntShiftCode()
    {
        return $this->hasOne(MntShiftCode::className(), ['id' => 'shift_code']);
    }
}
