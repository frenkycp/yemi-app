<?php

namespace app\models;

use Yii;
use \app\models\base\PrdDailyEff04 as BasePrdDailyEff04;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PRD_DAILY_EFF_04".
 */
class PrdDailyEff04 extends BasePrdDailyEff04
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
