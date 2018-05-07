<?php

namespace app\models;

use Yii;
use \app\models\base\ShipCustomer as BaseShipCustomer;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_ship_customer".
 */
class ShipCustomer extends BaseShipCustomer
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
