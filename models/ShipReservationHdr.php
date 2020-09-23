<?php

namespace app\models;

use Yii;
use \app\models\base\ShipReservationHdr as BaseShipReservationHdr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIP_RESERVATION_HDR".
 */
class ShipReservationHdr extends BaseShipReservationHdr
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
