<?php

namespace app\models;

use Yii;
use \app\models\base\WipPlanActualReport as BaseWipPlanActualReport;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_PLAN_ACTUAL_REPORT".
 */
class WipPlanActualReport extends BaseWipPlanActualReport
{
    public $total_plan, $total_order, $total_created, $total_started, $total_completed, $total_handover;

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
