<?php

namespace app\models;

use Yii;
use \app\models\base\ShippingContainerView01 as BaseShippingContainerView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "shipping_container_view_01".
 */
class ShippingContainerView01 extends BaseShippingContainerView01
{
    public $total_container;

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
