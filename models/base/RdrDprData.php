<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.RDR_DPR".
 *
 * @property string $material_document_number
 * @property string $material_document_number_barcode
 * @property string $period
 * @property string $rcv_date
 * @property string $vendor_code
 * @property string $vendor_name
 * @property string $pic
 * @property string $division
 * @property string $EMAIL_ADDRESS
 * @property string $EMAIL_ADDRESS_CC
 * @property string $NOTE
 * @property string $inv_no
 * @property string $material
 * @property string $description
 * @property string $um
 * @property double $do_inv_qty
 * @property double $act_rcv_qty
 * @property double $discrepancy_qty
 * @property double $standard_price
 * @property double $standard_amount
 * @property string $rdr_dpr
 * @property string $category
 * @property string $normal_urgent
 * @property string $user_id
 * @property string $user_desc
 * @property string $user_issue_date
 * @property string $korlap
 * @property string $korlap_desc
 * @property string $korlap_confirm_date
 * @property string $purc_approve
 * @property string $purc_approve_desc
 * @property string $purc_approve_date
 * @property string $discrepancy_treatment
 * @property string $payment_treatment
 * @property string $purc_approve_remark
 * @property string $eta_yemi
 * @property string $user_close
 * @property string $user_close_desc
 * @property string $user_close_date
 * @property integer $status_val
 * @property string $close_open
 * @property string $aliasModel
 */
abstract class RdrDprData extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.RDR_DPR';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_wsus');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_document_number'], 'required'],
            [['rcv_date', 'user_issue_date', 'korlap_confirm_date', 'purc_approve_date', 'eta_yemi', 'user_close_date'], 'safe'],
            [['do_inv_qty', 'act_rcv_qty', 'discrepancy_qty', 'standard_price', 'standard_amount'], 'number'],
            [['purc_approve_remark'], 'string'],
            [['status_val'], 'integer'],
            [['material_document_number'], 'string', 'max' => 24],
            [['material_document_number_barcode', 'pic', 'division', 'EMAIL_ADDRESS', 'EMAIL_ADDRESS_CC', 'NOTE', 'user_desc', 'korlap_desc', 'purc_approve_desc', 'user_close_desc'], 'string', 'max' => 50],
            [['period'], 'string', 'max' => 6],
            [['vendor_code', 'material'], 'string', 'max' => 11],
            [['vendor_name'], 'string', 'max' => 35],
            [['inv_no'], 'string', 'max' => 16],
            [['description', 'rdr_dpr', 'category', 'normal_urgent'], 'string', 'max' => 40],
            [['um'], 'string', 'max' => 3],
            [['user_id', 'korlap', 'purc_approve', 'user_close'], 'string', 'max' => 10],
            [['discrepancy_treatment', 'payment_treatment'], 'string', 'max' => 100],
            [['close_open'], 'string', 'max' => 1],
            [['material_document_number'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'material_document_number' => 'Material Document Number',
            'material_document_number_barcode' => 'Material Document Number Barcode',
            'period' => 'Period',
            'rcv_date' => 'Rcv Date',
            'vendor_code' => 'Vendor Code',
            'vendor_name' => 'Vendor Name',
            'pic' => 'Pic',
            'division' => 'Division',
            'EMAIL_ADDRESS' => 'Email Address',
            'EMAIL_ADDRESS_CC' => 'Email Address Cc',
            'NOTE' => 'Note',
            'inv_no' => 'Inv No',
            'material' => 'Material',
            'description' => 'Description',
            'um' => 'Um',
            'do_inv_qty' => 'Do Inv Qty',
            'act_rcv_qty' => 'Act Rcv Qty',
            'discrepancy_qty' => 'Discrepancy Qty',
            'standard_price' => 'Standard Price',
            'standard_amount' => 'Standard Amount',
            'rdr_dpr' => 'Rdr Dpr',
            'category' => 'Category',
            'normal_urgent' => 'Normal Urgent',
            'user_id' => 'User ID',
            'user_desc' => 'User Desc',
            'user_issue_date' => 'User Issue Date',
            'korlap' => 'Korlap',
            'korlap_desc' => 'Korlap Desc',
            'korlap_confirm_date' => 'Korlap Confirm Date',
            'purc_approve' => 'Purc Approve',
            'purc_approve_desc' => 'Purc Approve Desc',
            'purc_approve_date' => 'Purc Approve Date',
            'discrepancy_treatment' => 'Discrepancy Treatment',
            'payment_treatment' => 'Payment Treatment',
            'purc_approve_remark' => 'Purc Approve Remark',
            'eta_yemi' => 'Eta Yemi',
            'user_close' => 'User Close',
            'user_close_desc' => 'User Close Desc',
            'user_close_date' => 'User Close Date',
            'status_val' => 'Status Val',
            'close_open' => 'Close Open',
        ];
    }




}
