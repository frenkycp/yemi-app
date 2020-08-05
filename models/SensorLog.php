<?php

namespace app\models;

use Yii;
use \app\models\base\SensorLog as BaseSensorLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SENSOR_LOG".
 */
class SensorLog extends BaseSensorLog
{
    public $total_freq, $freq_shift1, $freq_shift2, $freq_shift3, $min_date, $max_date;

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
}
