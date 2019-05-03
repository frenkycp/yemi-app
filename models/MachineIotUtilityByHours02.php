<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotUtilityByHours02 as BaseMachineIotUtilityByHours02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_UTILITY_BY_HOURS_02".
 */
class MachineIotUtilityByHours02 extends BaseMachineIotUtilityByHours02
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
