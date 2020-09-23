<?php

namespace app\models;

use Yii;
use \app\models\base\ShipReservationDtr as BaseShipReservationDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIP_RESERVATION_DTR".
 */
class ShipReservationDtr extends BaseShipReservationDtr
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
                [['POD', 'CARRIER'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'BL_NO' => 'BL No.',
                'RESERVATION_NO' => 'Reservation No.',
                'HELP' => 'Help',
                'STATUS' => 'Status',
                'SHIPPER' => 'Shipper',
                'POL' => 'POL',
                'POD' => 'POD',
                'CNT_40HC' => 'Container 40 HC',
                'CNT_40' => 'Container 40',
                'CNT_20' => 'Container 20',
                'CARRIER' => 'Carrier',
                'FLAG_PRIORTY' => 'Flag Priorty',
                'FLAG_DESC' => 'Flag Desc',
                'ETD' => 'ETD',
                'APPLIED_RATE' => 'Applied Rate',
                'INVOICE' => 'Invoice',
                'NOTE' => 'Note',
            ]
        );
    }

    public function getShipReservationHdr()
    {
        return $this->hasOne(ShipReservationHdr::className(), ['RESERVATION_NO' => 'RESERVATION_NO']);
    }
}
