<?php

namespace app\models;

use Yii;
use \app\models\base\ShipItemM3 as BaseShipItemM3;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIP_ITEM_M3".
 */
class ShipItemM3 extends BaseShipItemM3
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
