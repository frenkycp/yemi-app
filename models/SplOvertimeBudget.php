<?php

namespace app\models;

use Yii;
use \app\models\base\SplOvertimeBudget as BaseSplOvertimeBudget;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SPL_OVERTIME_BUDGET".
 */
class SplOvertimeBudget extends BaseSplOvertimeBudget
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
