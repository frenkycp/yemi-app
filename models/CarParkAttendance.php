<?php

namespace app\models;

use Yii;
use \app\models\base\CarParkAttendance as BaseCarParkAttendance;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.CAR_PARK_ATTENDANCE".
 */
class CarParkAttendance extends BaseCarParkAttendance
{
    public $total_usage;

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
