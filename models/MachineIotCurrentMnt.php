<?php

namespace app\models;

use Yii;
use \app\models\base\MachineIotCurrentMnt as BaseMachineIotCurrentMnt;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_IOT_CURRENT".
 */
class MachineIotCurrentMnt extends BaseMachineIotCurrentMnt
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
