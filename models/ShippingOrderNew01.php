<?php

namespace app\models;

use Yii;
use \app\models\base\ShippingOrderNew01 as BaseShippingOrderNew01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIPPING_ORDER_NEW_01".
 */
class ShippingOrderNew01 extends BaseShippingOrderNew01
{
    public $TOTAL_CONFIRMED, $TOTAL_CONFIRMED_TEU, $TOTAL_UNCONFIRMED, $TOTAL_UNCONFIRMED_TEU, $TOTAL_ETD_YEMI, $TOTAL_ETD_YEMI_TEU, $TOTAL_ETD_SUB, $TOTAL_ETD_SUB_TEU, $TOTAL_ON_BOARD, $START_DATE, $END_DATE, $TOTAL_CONTAINER, $TOTAL_NO_NEED_ANYMORE;

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
