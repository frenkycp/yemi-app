<?php

namespace app\models;

use Yii;
use \app\models\base\MachineCorrectiveView01 as BaseMachineCorrectiveView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_CORRECTIVE_VIEW_01".
 */
class MachineCorrectiveView01 extends BaseMachineCorrectiveView01
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
