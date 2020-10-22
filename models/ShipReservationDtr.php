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
    public $main_40hc, $main_40, $main_20, $sub_40hc, $sub_40, $sub_20, $backup_40hc, $backup_40, $backup_20, $total_reservation;

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
                'DO_NO' => 'DO No.',
                'YCJ_REF_NO' => 'YCJ Ref. No.',
                'RESERVATION_NO' => 'Reservation No.',
                'HELP' => 'Help',
                'STATUS' => 'Status',
                'SHIPPER' => 'Shipper',
                'POL' => 'POL',
                'POD' => 'POD',
                'CNT_40HC' => '40 HC',
                'CNT_40' => '40',
                'CNT_20' => '20',
                'CARRIER' => 'Carrier',
                'FLAG_PRIORTY' => 'Flag Priorty',
                'FLAG_DESC' => 'Flag Desc',
                'ETD' => 'ETD YEMI',
                'APPLIED_RATE' => 'Applied Rate',
                'INVOICE' => 'Invoice',
                'NOTE' => 'Note',
            ]
        );
    }

    public function getShipReservationHdr()
    {
        return $this->hasOne(ShipReservationHdr::className(), ['YCJ_REF_NO' => 'YCJ_REF_NO']);
    }
}
