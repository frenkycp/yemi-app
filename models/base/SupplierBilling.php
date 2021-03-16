<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SUPPLIER_BILLING".
 *
 * @property string $no
 * @property string $supplier_name
 * @property integer $id
 * @property string $UserName
 * @property string $Email
 * @property string $supplier_pic
 * @property string $receipt_no
 * @property string $invoice_no
 * @property string $delivery_no
 * @property string $tax_no
 * @property string $cur
 * @property double $amount
 * @property string $doc_upload_by
 * @property string $doc_upload_date
 * @property string $doc_upload_stat
 * @property string $doc_received_by
 * @property string $doc_received_date
 * @property string $doc_received_stat
 * @property string $doc_pch_finished_by
 * @property string $doc_pch_finished_date
 * @property string $doc_pch_finished_stat
 * @property string $doc_finance_handover_by
 * @property string $doc_finance_handover_date
 * @property string $doc_finance_handover_stat
 * @property string $document_link
 * @property integer $stage
 * @property string $open_close
 * @property string $remark
 * @property string $dokumen
 * @property string $aliasModel
 */
abstract class SupplierBilling extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SUPPLIER_BILLING';
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
            [['no'], 'required'],
            [['id', 'stage'], 'integer'],
            [['amount'], 'number'],
            [['doc_upload_date', 'doc_received_date', 'doc_pch_finished_date', 'doc_finance_handover_date'], 'safe'],
            [['no', 'UserName', 'Email', 'supplier_pic', 'doc_upload_by', 'doc_upload_stat', 'doc_received_by', 'doc_received_stat', 'doc_finance_handover_by', 'doc_finance_handover_stat', 'open_close'], 'string', 'max' => 50],
            [['supplier_name', 'receipt_no', 'invoice_no', 'tax_no'], 'string', 'max' => 255],
            [['delivery_no'], 'string', 'max' => 1000],
            [['cur'], 'string', 'max' => 10],
            [['remark'], 'string', 'max' => 100],
            [['no'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no' => 'No',
            'supplier_name' => 'Supplier Name',
            'id' => 'ID',
            'UserName' => 'User Name',
            'Email' => 'Email',
            'supplier_pic' => 'Supplier Pic',
            'receipt_no' => 'Receipt No',
            'invoice_no' => 'Invoice No',
            'delivery_no' => 'Delivery No',
            'tax_no' => 'Tax No',
            'cur' => 'Cur',
            'amount' => 'Amount',
            'doc_upload_by' => 'Doc Upload By',
            'doc_upload_date' => 'Doc Upload Date',
            'doc_upload_stat' => 'Doc Upload Stat',
            'doc_received_by' => 'Doc Received By',
            'doc_received_date' => 'Doc Received Date',
            'doc_received_stat' => 'Doc Received Stat',
            'doc_pch_finished_by' => 'Doc Pch Finished By',
            'doc_pch_finished_date' => 'Doc Pch Finished Date',
            'doc_pch_finished_stat' => 'Doc Pch Finished Stat',
            'doc_finance_handover_by' => 'Doc Finance Handover By',
            'doc_finance_handover_date' => 'Doc Finance Handover Date',
            'doc_finance_handover_stat' => 'Doc Finance Handover Stat',
            'document_link' => 'Document Link',
            'stage' => 'Stage',
            'open_close' => 'Open Close',
            'remark' => 'Remark',
            'dokumen' => 'Dokumen',
        ];
    }




}
