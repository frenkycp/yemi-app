<?php

namespace app\models;

use Yii;
use \app\models\base\DailyProductionOutput01 as BaseDailyProductionOutput01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "daily_production_output_01".
 */
class DailyProductionOutput01 extends BaseDailyProductionOutput01
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
