<?php

namespace app\models;

use Yii;
use \app\models\base\MachinePerformanceView01 as BaseMachinePerformanceView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_PERFORMANCE_VIEW_01".
 */
class MachinePerformanceView01 extends BaseMachinePerformanceView01
{
    public $mttr, $mtbf;

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
