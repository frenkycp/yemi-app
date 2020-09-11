<?php

namespace app\models;

use Yii;
use \app\models\base\StoreOnhandWsus as BaseStoreOnhandWsus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.STORE_ONHAND".
 */
class StoreOnhandWsus extends BaseStoreOnhandWsus
{
    public $total_open, $total_close;

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
