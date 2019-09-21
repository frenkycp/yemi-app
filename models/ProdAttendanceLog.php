<?php

namespace app\models;

use Yii;
use \app\models\base\ProdAttendanceLog as BaseProdAttendanceLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_ATTENDANCE_LOG".
 */
class ProdAttendanceLog extends BaseProdAttendanceLog
{
    public $nik, $name;

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

    public function getProdAttendanceData()
    {
        return $this->hasOne(ProdAttendanceData::className(), ['att_data_id' => 'att_data_id']);
    }
}
