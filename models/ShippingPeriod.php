<?php

namespace app\models;

use Yii;
use \app\models\base\ShippingPeriod as BaseShippingPeriod;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIPPING_PERIOD".
 */
class ShippingPeriod extends BaseShippingPeriod
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
