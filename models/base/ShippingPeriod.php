<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SHIPPING_PERIOD".
 *
 * @property integer $SEQ
 * @property string $ID
 * @property string $PERIOD
 * @property string $DESTINATION
 * @property string $BU
 * @property string $LINE
 * @property string $MODEL
 * @property string $FG_KD
 * @property string $ITEM
 * @property string $material_description
 * @property double $standard_price
 * @property string $hpl_desc
 * @property double $BEGIN_QTY
 * @property double $RCV_QTY
 * @property double $ISSUE_QTY
 * @property double $ENDING_QTY
 * @property double $BEGIN_AMT
 * @property double $RCV_AMT
 * @property double $ISSUE_AMT
 * @property double $ENDING_AMT
 * @property double $item_m3
 * @property double $ENDING_M3
 * @property string $aliasModel
 */
abstract class ShippingPeriod extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SHIPPING_PERIOD';
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
            [['ID'], 'required'],
            [['standard_price', 'BEGIN_QTY', 'RCV_QTY', 'ISSUE_QTY', 'ENDING_QTY', 'BEGIN_AMT', 'RCV_AMT', 'ISSUE_AMT', 'ENDING_AMT', 'item_m3', 'ENDING_M3'], 'number'],
            [['ID', 'DESTINATION', 'BU', 'LINE', 'MODEL', 'FG_KD', 'hpl_desc'], 'string', 'max' => 50],
            [['PERIOD'], 'string', 'max' => 6],
            [['ITEM'], 'string', 'max' => 13],
            [['material_description'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SEQ' => 'Seq',
            'ID' => 'ID',
            'PERIOD' => 'Period',
            'DESTINATION' => 'Destination',
            'BU' => 'Bu',
            'LINE' => 'Line',
            'MODEL' => 'Model',
            'FG_KD' => 'Fg Kd',
            'ITEM' => 'Item',
            'material_description' => 'Material Description',
            'standard_price' => 'Standard Price',
            'hpl_desc' => 'Hpl Desc',
            'BEGIN_QTY' => 'Begin Qty',
            'RCV_QTY' => 'Rcv Qty',
            'ISSUE_QTY' => 'Issue Qty',
            'ENDING_QTY' => 'Ending Qty',
            'BEGIN_AMT' => 'Begin Amt',
            'RCV_AMT' => 'Rcv Amt',
            'ISSUE_AMT' => 'Issue Amt',
            'ENDING_AMT' => 'Ending Amt',
            'item_m3' => 'Item M3',
            'ENDING_M3' => 'Ending M3',
        ];
    }




}
