<?php

namespace app\models;

use Yii;
use \app\models\base\TraceItemDtrView as BaseTraceItemDtrView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TRACE_ITEM_DTR_VIEW".
 */
class TraceItemDtrView extends BaseTraceItemDtrView
{
    public $TOTAL_KG, $TOTAL_L;

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
