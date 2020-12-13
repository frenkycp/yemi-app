<?php

namespace app\models;

use Yii;
use \app\models\base\TemperatureDailyView01 as BaseTemperatureDailyView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TEMPERATURE_DAILY_VIEW_01".
 */
class TemperatureDailyView01 extends BaseTemperatureDailyView01
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
