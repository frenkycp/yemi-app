<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIot as BaseMachineIot;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT".
 */
class MachineIot extends BaseMachineIot
{
    public $start_kwh, $end_kwh;

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
