<?php

namespace app\models;

use Yii;
use \app\models\base\MachinePerformanceView03 as BaseMachinePerformanceView03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_PERFORMANCE_VIEW_03".
 */
class MachinePerformanceView03 extends BaseMachinePerformanceView03
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
