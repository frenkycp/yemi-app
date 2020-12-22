<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotLogHour as BaseMachineIotLogHour;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_LOG_HOUR".
 */
class MachineIotLogHour extends BaseMachineIotLogHour
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
