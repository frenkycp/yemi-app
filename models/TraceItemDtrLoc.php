<?php

namespace app\models;

use Yii;
use \app\models\base\TraceItemDtrLoc as BaseTraceItemDtrLoc;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TRACE_ITEM_DTR_LOC".
 */
class TraceItemDtrLoc extends BaseTraceItemDtrLoc
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
