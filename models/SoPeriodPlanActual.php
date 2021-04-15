<?php

namespace app\models;

use Yii;
use \app\models\base\SoPeriodPlanActual as BaseSoPeriodPlanActual;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SO_PERIOD_PLAN_ACTUAL".
 */
class SoPeriodPlanActual extends BaseSoPeriodPlanActual
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
