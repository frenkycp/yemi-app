<?php

namespace app\models;

use Yii;
use \app\models\base\PrdMonthlyEff03 as BasePrdMonthlyEff03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PRD_MONTHLY_EFF_03".
 */
class PrdMonthlyEff03 extends BasePrdMonthlyEff03
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
