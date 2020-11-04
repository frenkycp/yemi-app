<?php

namespace app\models;

use Yii;
use \app\models\base\TraceItemHdr as BaseTraceItemHdr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TRACE_ITEM_HDR".
 */
class TraceItemHdr extends BaseTraceItemHdr
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
