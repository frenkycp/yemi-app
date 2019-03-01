<?php

namespace app\models;

use Yii;
use \app\models\base\SplViewMonthlySection02 as BaseSplViewMonthlySection02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SPL_VIEW_MONTHLY_SECTION_02".
 */
class SplViewMonthlySection02 extends BaseSplViewMonthlySection02
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
