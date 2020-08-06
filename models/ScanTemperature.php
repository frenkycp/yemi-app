<?php

namespace app\models;

use Yii;
use \app\models\base\ScanTemperature as BaseScanTemperature;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SCAN_TEMPERATURE".
 */
class ScanTemperature extends BaseScanTemperature
{
    public $from_time, $to_time;

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
