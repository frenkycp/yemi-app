<?php

namespace app\models;

use Yii;
use \app\models\base\SensorTbl as BaseSensorTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SENSOR_TBL".
 */
class SensorTbl extends BaseSensorTbl
{
    public $value;

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

    public function getLocationArea()
    {
        return $this->location . ' (' . $this->area . ')';
    }
}
