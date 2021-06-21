<?php

namespace app\models;

use Yii;
use \app\models\base\MesinCheckResult01 as BaseMesinCheckResult01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_CHECK_RESULT_01".
 */
class MesinCheckResult01 extends BaseMesinCheckResult01
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
