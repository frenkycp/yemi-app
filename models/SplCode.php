<?php

namespace app\models;

use Yii;
use \app\models\base\SplCode as BaseSplCode;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SPL_CODE".
 */
class SplCode extends BaseSplCode
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
