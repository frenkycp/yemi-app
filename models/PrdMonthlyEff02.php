<?php

namespace app\models;

use Yii;
use \app\models\base\PrdMonthlyEff02 as BasePrdMonthlyEff02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PRD_MONTHLY_EFF_02".
 */
class PrdMonthlyEff02 extends BasePrdMonthlyEff02
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
