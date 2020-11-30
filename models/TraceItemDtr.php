<?php

namespace app\models;

use Yii;
use \app\models\base\TraceItemDtr as BaseTraceItemDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TRACE_ITEM_DTR".
 */
class TraceItemDtr extends BaseTraceItemDtr
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

    public function getItemDescription()
    {
        return $this->ITEM_DESC . ' (' . $this->ITEM . ')';
    }
}
