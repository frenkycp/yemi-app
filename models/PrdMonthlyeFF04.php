<?php

namespace app\models;

use Yii;
use \app\models\base\PrdMonthlyeFF04 as BasePrdMonthlyeFF04;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PRD_MONTHLY_EFF_04".
 */
class PrdMonthlyeFF04 extends BasePrdMonthlyeFF04
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
