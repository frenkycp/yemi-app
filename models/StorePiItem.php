<?php

namespace app\models;

use Yii;
use \app\models\base\StorePiItem as BaseStorePiItem;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.STORE_PI_ITEM".
 */
class StorePiItem extends BaseStorePiItem
{
    public $total_open, $total1, $total2, $total3, $total4, $total, $total_all;

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
