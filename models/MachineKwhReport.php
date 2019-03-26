<?php

namespace app\models;

use Yii;
use \app\models\base\MachineKwhReport as BaseMachineKwhReport;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_KWH_REPORT".
 */
class MachineKwhReport extends BaseMachineKwhReport
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
