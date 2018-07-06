<?php

namespace app\models;

use Yii;
use \app\models\base\MesinCheckResult as BaseMesinCheckResult;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_CHECK_RESULT".
 */
class MesinCheckResult extends BaseMesinCheckResult
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
