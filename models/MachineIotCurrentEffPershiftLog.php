<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotCurrentEffPershiftLog as BaseMachineIotCurrentEffPershiftLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_CURRENT_EFF_PERSHIFT_LOG".
 */
class MachineIotCurrentEffPershiftLog extends BaseMachineIotCurrentEffPershiftLog
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
