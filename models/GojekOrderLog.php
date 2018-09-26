<?php

namespace app\models;

use Yii;
use \app\models\base\GojekOrderLog as BaseGojekOrderLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GOJEK_ORDER_LOG".
 */
class GojekOrderLog extends BaseGojekOrderLog
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