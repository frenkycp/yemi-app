<?php

namespace app\models;

use Yii;
use \app\models\base\StorePiItemLog as BaseStorePiItemLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.STORE_PI_ITEM_LOG".
 */
class StorePiItemLog extends BaseStorePiItemLog
{
    public $total_slip;

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
