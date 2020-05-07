<?php

namespace app\models;

use Yii;
use \app\models\base\ScanTemperatureDaily01 as BaseScanTemperatureDaily01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SCAN_TEMPERATURE_DAILY_01".
 */
class ScanTemperatureDaily01 extends BaseScanTemperatureDaily01
{

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
