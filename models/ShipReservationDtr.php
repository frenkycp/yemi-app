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
                [['POD', 'CARRIER', 'ETD_SUB', 'ETD', 'PERIOD'], 'required'],
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
                'CNT_40HC' => 'Container 40 HC',
                'CNT_40' => 'Container 40',
                'CNT_20' => 'Container 20',
                'LCL' => 'LCL',
                'CARRIER' => 'Carrier',
                'FLAG_PRIORTY' => 'Flag Priorty',
                'FLAG_DESC' => 'Flag Desc',
                'ETD' => 'ETD YEMI',
                'ETD_SUB' => 'ETD SUB',
                'APPLIED_RATE' => 'Applied Rate',
                'INVOICE' => 'Invoice',
                'NOTE' => 'Note',
                'KD_FLAG' => 'KD Flag',
            ]
        );
    }

    public function getShipReservationHdr()
    {
        return $this->hasOne(ShipReservationHdr::className(), ['YCJ_REF_NO' => 'YCJ_REF_NO']);
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            date_default_timezone_set('Asia/Jakarta');
            $this->HDR_ID = $this->PERIOD . $this->YCJ_REF_NO;

            $this->UPDATED_BY_ID = $this->UPDATED_BY_NAME = \Yii::$app->user->identity->username;
            $creator = Karyawan::find()->where([
                'OR',
                ['NIK' => \Yii::$app->user->identity->username],
                ['NIK_SUN_FISH' => \Yii::$app->user->identity->username]
            ])->one();
            if ($creator) {
                $this->UPDATED_BY_ID = $creator->NIK_SUN_FISH;
                $this->UPDATED_BY_NAME = $creator->NAMA_KARYAWAN;
            }
            $this->LAST_UPDATE = date('Y-m-d H:i:s');

            $tmp_hdr = ShipReservationHdr::find()->where(['HDR_ID' => $this->HDR_ID])->one();
            if (!$tmp_hdr) {
                $tmp_hdr = new ShipReservationHdr;
                $tmp_hdr->PERIOD = $this->PERIOD;
                $tmp_hdr->HDR_ID = $this->HDR_ID;
                $tmp_hdr->YCJ_REF_NO = $this->YCJ_REF_NO;
                $tmp_hdr->POD = $this->POD;

                $tmp_hdr->UPDATED_BY_ID = $this->UPDATED_BY_ID;
                $tmp_hdr->UPDATED_BY_NAME = $this->UPDATED_BY_NAME;
                $tmp_hdr->LAST_UPDATE = $this->LAST_UPDATE;

                $tmp_hdr->save();
            }

            return true;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $hdr = ShipReservationHdr::find()->where(['HDR_ID' => $this->HDR_ID])->one();

        $shipping_order_view1 = ShippingOrderView01::find()->where(['HDR_ID' => $this->HDR_ID])->one();
        $hdr->CONFIRM_40HC = $hdr->CONFIRM_40 = $hdr->CONFIRM_20 = $hdr->CONFIRM_LCL = $hdr->UNCONFIRM_40HC = $hdr->UNCONFIRM_40 = $hdr->UNCONFIRM_20 = $hdr->UNCONFIRM_LCL = $hdr->TOTAL_CONFIRM = $hdr->TOTAL_UNCONFIRM = 0;

        $hdr->CONFIRM_40HC = $shipping_order_view1->CONFIRM_40HC;
        $hdr->CONFIRM_40 = $shipping_order_view1->CONFIRM_40;
        $hdr->CONFIRM_20 = $shipping_order_view1->CONFIRM_20;
        $hdr->CONFIRM_LCL = $shipping_order_view1->CONFIRM_LCL;
        $hdr->UNCONFIRM_40HC = $shipping_order_view1->UNCONFIRM_40HC;
        $hdr->UNCONFIRM_40 = $shipping_order_view1->UNCONFIRM_40;
        $hdr->UNCONFIRM_20 = $shipping_order_view1->UNCONFIRM_20;
        $hdr->UNCONFIRM_LCL = $shipping_order_view1->UNCONFIRM_LCL;

        $hdr->TOTAL_CONFIRM = $shipping_order_view1->CONFIRM_40HC + $shipping_order_view1->CONFIRM_40 + $shipping_order_view1->CONFIRM_20 + $shipping_order_view1->CONFIRM_LCL;
        $hdr->TOTAL_UNCONFIRM = $shipping_order_view1->UNCONFIRM_40HC + $shipping_order_view1->UNCONFIRM_40 + $shipping_order_view1->UNCONFIRM_20 + $shipping_order_view1->UNCONFIRM_LCL;

        $hdr->STATUS_CONFIRMED = $shipping_order_view1->STATUS_CONFIRMED;
        $hdr->UPDATED_BY_ID = $this->UPDATED_BY_ID;
        $hdr->UPDATED_BY_NAME = $this->UPDATED_BY_NAME;
        $hdr->LAST_UPDATE = $this->LAST_UPDATE;

        $hdr->save();
        
    }
}
