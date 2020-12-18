<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotSingle as BaseMachineIotSingle;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_SINGLE".
 */
class MachineIotSingle extends BaseMachineIotSingle
{
    public $total_down_time, $total_down_time_number;

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
