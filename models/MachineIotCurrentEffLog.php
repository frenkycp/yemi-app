<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotCurrentEffLog as BaseMachineIotCurrentEffLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_CURRENT_EFF_LOG".
 */
class MachineIotCurrentEffLog extends BaseMachineIotCurrentEffLog
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
