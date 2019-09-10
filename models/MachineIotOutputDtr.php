<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotOutputDtr as BaseMachineIotOutputDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_OUTPUT_DTR".
 */
class MachineIotOutputDtr extends BaseMachineIotOutputDtr
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
