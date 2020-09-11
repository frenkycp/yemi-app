<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotOutput as BaseMachineIotOutput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_OUTPUT".
 */
class MachineIotOutput extends BaseMachineIotOutput
{
    public $child_analyst;

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
