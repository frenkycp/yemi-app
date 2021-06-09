<?php

namespace app\models;

use Yii;
use \app\models\base\HikTemperatureView as BaseHikTemperatureView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.TEMPERATURE_VIEW".
 */
class HikTemperatureView extends BaseHikTemperatureView
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
