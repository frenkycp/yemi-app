<?php

namespace app\models;

use Yii;
use \app\models\base\AvgPowerConsumptionView as BaseAvgPowerConsumptionView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.AVG_POWER_CONSUMPTION_VIEW".
 */
class AvgPowerConsumptionView extends BaseAvgPowerConsumptionView
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
