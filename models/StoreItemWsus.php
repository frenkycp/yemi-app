<?php

namespace app\models;

use Yii;
use \app\models\base\StoreItemWsus as BaseStoreItemWsus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.STORE_ITEM".
 */
class StoreItemWsus extends BaseStoreItemWsus
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
