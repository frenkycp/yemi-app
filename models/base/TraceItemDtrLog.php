<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.TRACE_ITEM_DTR_LOG".
 *
 * @property integer $SEQ
 * @property string $SERIAL_NO
 * @property string $ITEM
 * @property string $ITEM_DESC
 * @property string $SUPPLIER
 * @property string $SUPPLIER_DESC
 * @property string $UM
 * @property string $LOT_NO
 * @property string $RECEIVED_DATE
 * @property string $SURAT_JALAN
 * @property string $MANUFACTURED_DATE
 * @property string $EXPIRED_DATE
 * @property integer $EXPIRED_REVISION_NO
 * @property double $LIFE_TIME
 * @property string $BENTUK_KEMASAN
 * @property double $ISI_DALAM_KEMASAN
 * @property double $NILAI_INVENTORY
 * @property double $STD_PRICE
 * @property double $STD_AMT
 * @property string $USER_ID
 * @property string $USER_DESC
 * @property string $LAST_UPDATE
 * @property string $AVAILABLE
 * @property string $CATEGORY
 * @property string $TRANS_ID
 * @property double $QTY_IN
 * @property double $QTY_OUT
 * @property string $LOC
 * @property string $LOC_DESC
 * @property string $POST_DATE
 * @property string $PERIOD
 * @property string $aliasModel
 */
abstract class TraceItemDtrLog extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.TRACE_ITEM_DTR_LOG';
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
            [['RECEIVED_DATE', 'MANUFACTURED_DATE', 'EXPIRED_DATE', 'LAST_UPDATE', 'POST_DATE'], 'safe'],
            [['EXPIRED_REVISION_NO'], 'integer'],
            [['LIFE_TIME', 'ISI_DALAM_KEMASAN', 'NILAI_INVENTORY', 'STD_PRICE', 'STD_AMT', 'QTY_IN', 'QTY_OUT'], 'number'],
            [['SERIAL_NO', 'SUPPLIER', 'LOT_NO', 'SURAT_JALAN', 'BENTUK_KEMASAN', 'USER_DESC', 'CATEGORY', 'TRANS_ID', 'LOC_DESC'], 'string', 'max' => 50],
            [['ITEM'], 'string', 'max' => 13],
            [['ITEM_DESC', 'SUPPLIER_DESC'], 'string', 'max' => 100],
            [['UM'], 'string', 'max' => 5],
            [['USER_ID', 'LOC'], 'string', 'max' => 10],
            [['AVAILABLE'], 'string', 'max' => 1],
            [['PERIOD'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SEQ' => 'Seq',
            'SERIAL_NO' => 'Serial No',
            'ITEM' => 'Item',
            'ITEM_DESC' => 'Item Desc',
            'SUPPLIER' => 'Supplier',
            'SUPPLIER_DESC' => 'Supplier Desc',
            'UM' => 'Um',
            'LOT_NO' => 'Lot No',
            'RECEIVED_DATE' => 'Received Date',
            'SURAT_JALAN' => 'Surat Jalan',
            'MANUFACTURED_DATE' => 'Manufactured Date',
            'EXPIRED_DATE' => 'Expired Date',
            'EXPIRED_REVISION_NO' => 'Expired Revision No',
            'LIFE_TIME' => 'Life Time',
            'BENTUK_KEMASAN' => 'Bentuk Kemasan',
            'ISI_DALAM_KEMASAN' => 'Isi Dalam Kemasan',
            'NILAI_INVENTORY' => 'Nilai Inventory',
            'STD_PRICE' => 'Std Price',
            'STD_AMT' => 'Std Amt',
            'USER_ID' => 'User ID',
            'USER_DESC' => 'User Desc',
            'LAST_UPDATE' => 'Last Update',
            'AVAILABLE' => 'Available',
            'CATEGORY' => 'Category',
            'TRANS_ID' => 'Trans ID',
            'QTY_IN' => 'Qty In',
            'QTY_OUT' => 'Qty Out',
            'LOC' => 'Loc',
            'LOC_DESC' => 'Loc Desc',
            'POST_DATE' => 'Post Date',
            'PERIOD' => 'Period',
        ];
    }




}
