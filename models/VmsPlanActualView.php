<?php

namespace app\models;

use Yii;
use \app\models\base\VmsPlanActualView as BaseVmsPlanActualView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.VMS_PLAN_ACTUAL_VIEW".
 */
class VmsPlanActualView extends BaseVmsPlanActualView
{
    public $kd_plan, $kd_actual, $product_plan, $product_actual;

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
