<?php

namespace app\models;

use Yii;
use \app\models\base\TemperatureOverAction as BaseTemperatureOverAction;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TEMPERATURE_OVER_ACTION".
 */
class TemperatureOverAction extends BaseTemperatureOverAction
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
