<?php

namespace app\models;

use Yii;
use \app\models\base\TraceItemDtrLog as BaseTraceItemDtrLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TRACE_ITEM_DTR_LOG".
 */
class TraceItemDtrLog extends BaseTraceItemDtrLog
{
    public $QTY;

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
