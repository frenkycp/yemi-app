<?php

namespace app\models;

use Yii;
use \app\models\base\ProdDailyProgress01 as BaseProdDailyProgress01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "prod_daily_progress_01".
 */
class ProdDailyProgress01 extends BaseProdDailyProgress01
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
