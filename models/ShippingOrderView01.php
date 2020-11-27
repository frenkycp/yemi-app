<?php

namespace app\models;

use Yii;
use \app\models\base\ShippingOrderView01 as BaseShippingOrderView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIPPING_ORDER_VIEW_01".
 */
class ShippingOrderView01 extends BaseShippingOrderView01
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
