<?php

namespace app\models;

use Yii;
use \app\models\base\BookingShipTrackView as BaseBookingShipTrackView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.BOOKING_SHIP_TRACK_03".
 */
class BookingShipTrackView extends BaseBookingShipTrackView
{
    public $total, $total_open, $total_close, $total_open2;

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
