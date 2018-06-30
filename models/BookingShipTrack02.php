<?php

namespace app\models;

use Yii;
use \app\models\base\BookingShipTrack02 as BaseBookingShipTrack02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.BOOKING_SHIP_TRACK_02".
 */
class BookingShipTrack02 extends BaseBookingShipTrack02
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
