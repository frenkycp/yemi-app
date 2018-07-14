<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SALES_BUDGET_COMPARE".
 *
 * @property string $ITEM_INDEX
 * @property string $ITEM
 * @property string $DESC
 * @property string $NO
 * @property string $MODEL
 * @property string $MODEL_GROUP
 * @property string $BU
 * @property string $TYPE
 * @property string $FISCAL
 * @property string $PERIOD
 * @property double $QTY_BGT
 * @property double $AMOUNT_BGT
 * @property double $QTY_ACT_FOR
 * @property double $AMOUNT_ACT_FOR
 * @property double $QTY_BALANCE
 * @property double $AMOUNT_BALANCE
 * @property string $aliasModel
 */
abstract class SalesBudgetCompare extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SALES_BUDGET_COMPARE';
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
            [['ITEM_INDEX', 'ITEM'], 'required'],
            [['ITEM_INDEX', 'ITEM', 'DESC', 'NO', 'MODEL', 'MODEL_GROUP', 'BU', 'TYPE', 'FISCAL', 'PERIOD'], 'string'],
            [['QTY_BGT', 'AMOUNT_BGT', 'QTY_ACT_FOR', 'AMOUNT_ACT_FOR', 'QTY_BALANCE', 'AMOUNT_BALANCE'], 'number'],
            [['ITEM_INDEX'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ITEM_INDEX' => 'Item  Index',
            'ITEM' => 'Item',
            'DESC' => 'Desc',
            'NO' => 'No',
            'MODEL' => 'Model',
            'MODEL_GROUP' => 'Model  Group',
            'BU' => 'Bu',
            'TYPE' => 'Type',
            'FISCAL' => 'Fiscal',
            'PERIOD' => 'Period',
            'QTY_BGT' => 'Qty  Bgt',
            'AMOUNT_BGT' => 'Amount  Bgt',
            'QTY_ACT_FOR' => 'Qty  Act  For',
            'AMOUNT_ACT_FOR' => 'Amount  Act  For',
            'QTY_BALANCE' => 'Qty  Balance',
            'AMOUNT_BALANCE' => 'Amount  Balance',
        ];
    }




}
