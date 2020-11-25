<?php

namespace app\models;

use Yii;
use \app\models\base\ShippingOrderView03 as BaseShippingOrderView03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIPPING_ORDER_VIEW_03".
 */
class ShippingOrderView03 extends BaseShippingOrderView03
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
