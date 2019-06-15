<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotCurrentEff as BaseMachineIotCurrentEff;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_CURRENT_EFF".
 */
class MachineIotCurrentEff extends BaseMachineIotCurrentEff
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
