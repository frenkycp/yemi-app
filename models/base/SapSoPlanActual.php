<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SAP_SO_PLAN_ACTUAL".
 *
 * @property integer $seq
 * @property string $billing_ID
 * @property string $so_id
 * @property string $billing_document
 * @property string $billing_item
 * @property double $quantity
 * @property string $currency
 * @property string $price_master
 * @property string $price_invoice
 * @property string $amount
 * @property string $ycj_iv
 * @property string $billing_date
 * @property string $our_ref_number
 * @property string $bl_no
 * @property string $eta
 * @property string $do_number
 * @property integer $period_plan
 * @property integer $period_act
 * @property integer $deviasi
 * @property string $otd
 * @property string $so_open_close
 * @property string $material_number
 * @property string $material_description
 * @property string $so_no
 * @property string $so_line
 * @property string $ship_to
 * @property string $ship_to_name
 * @property string $po_no_01
 * @property string $po_no_02
 * @property string $BU
 * @property string $LINE
 * @property string $MODEL
 * @property string $FG_KD
 * @property string $period_act_rate_id
 * @property string $period_plan_rate_id
 * @property double $period_act_rate
 * @property double $period_plan_rate
 * @property double $amount_usd
 * @property string $aliasModel
 */
abstract class SapSoPlanActual extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SAP_SO_PLAN_ACTUAL';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sql_server');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quantity', 'period_act_rate', 'period_plan_rate', 'amount_usd'], 'number'],
            [['do_number'], 'string'],
            [['period_plan', 'period_act', 'deviasi'], 'integer'],
            [['billing_ID', 'so_id', 'billing_document', 'billing_item', 'currency', 'price_master', 'price_invoice', 'amount', 'ycj_iv', 'billing_date', 'our_ref_number', 'bl_no', 'eta', 'otd', 'so_open_close', 'material_number', 'material_description', 'so_no', 'so_line', 'ship_to', 'ship_to_name', 'po_no_01', 'po_no_02', 'BU', 'LINE', 'MODEL', 'FG_KD', 'period_act_rate_id', 'period_plan_rate_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'seq' => 'Seq',
            'billing_ID' => 'Billing ID',
            'so_id' => 'So ID',
            'billing_document' => 'Billing Document',
            'billing_item' => 'Billing Item',
            'quantity' => 'Quantity',
            'currency' => 'Currency',
            'price_master' => 'Price Master',
            'price_invoice' => 'Price Invoice',
            'amount' => 'Amount',
            'ycj_iv' => 'Ycj Iv',
            'billing_date' => 'Billing Date',
            'our_ref_number' => 'Our Ref Number',
            'bl_no' => 'Bl No',
            'eta' => 'Eta',
            'do_number' => 'Do Number',
            'period_plan' => 'Period Plan',
            'period_act' => 'Period Act',
            'deviasi' => 'Deviasi',
            'otd' => 'Otd',
            'so_open_close' => 'So Open Close',
            'material_number' => 'Material Number',
            'material_description' => 'Material Description',
            'so_no' => 'So No',
            'so_line' => 'So Line',
            'ship_to' => 'Ship To',
            'ship_to_name' => 'Ship To Name',
            'po_no_01' => 'Po No 01',
            'po_no_02' => 'Po No 02',
            'BU' => 'Bu',
            'LINE' => 'Line',
            'MODEL' => 'Model',
            'FG_KD' => 'Fg Kd',
            'period_act_rate_id' => 'Period Act Rate ID',
            'period_plan_rate_id' => 'Period Plan Rate ID',
            'period_act_rate' => 'Period Act Rate',
            'period_plan_rate' => 'Period Plan Rate',
            'amount_usd' => 'Amount Usd',
        ];
    }




}
