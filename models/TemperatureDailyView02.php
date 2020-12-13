<?php

namespace app\models;

use Yii;
use \app\models\base\TemperatureDailyView02 as BaseTemperatureDailyView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TEMPERATURE_DAILY_VIEW_02".
 */
class TemperatureDailyView02 extends BaseTemperatureDailyView02
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
