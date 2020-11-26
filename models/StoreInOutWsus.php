<?php

namespace app\models;

use Yii;
use \app\models\base\StoreInOutWsus as BaseStoreInOutWsus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.STORE_IN_OUT".
 */
class StoreInOutWsus extends BaseStoreInOutWsus
{
    public $TOTAL_ITEM, $TOTAL_OK, $TOTAL_NG, $TOTAL_OPEN, $TOTAL_COUNT, $TOTAL_QTY;

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
