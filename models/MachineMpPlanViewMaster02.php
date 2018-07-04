<?php

namespace app\models;

use Yii;
use \app\models\base\MachineMpPlanViewMaster02 as BaseMachineMpPlanViewMaster02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MACHINE_MP_PLAN_VIEW_MASTER_02".
 */
class MachineMpPlanViewMaster02 extends BaseMachineMpPlanViewMaster02
{
    public $total_open, $total_close, $total_plan, $min_year;

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
