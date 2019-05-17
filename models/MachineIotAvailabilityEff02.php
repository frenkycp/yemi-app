<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotAvailabilityEff02 as BaseMachineIotAvailabilityEff02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_AVAILABILITY_EFF_02".
 */
class MachineIotAvailabilityEff02 extends BaseMachineIotAvailabilityEff02
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
