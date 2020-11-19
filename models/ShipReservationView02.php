<?php

namespace app\models;

use Yii;
use \app\models\base\ShipReservationView02 as BaseShipReservationView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIP_RESERVATION_VIEW_02".
 */
class ShipReservationView02 extends BaseShipReservationView02
{
    public $total_confirm, $total_not_confirm, $total_all;

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
