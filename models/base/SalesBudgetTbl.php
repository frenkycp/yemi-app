<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SALES_BUDGET_TBL".
 *
 * @property integer $SEQ
 * @property string $CATEGORY
 * @property string $FISCAL
 * @property string $NO
 * @property string $MODEL
 * @property string $PERIOD
 * @property double $QTY
 * @property double $AMOUNT
 * @property string $BU
 * @property string $TYPE
 * @property string $LAST_UPDATE
 * @property string $aliasModel
 */
abstract class SalesBudgetTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SALES_BUDGET_TBL';
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
            [['CATEGORY', 'FISCAL', 'NO', 'MODEL', 'PERIOD', 'BU', 'TYPE'], 'string'],
            [['QTY', 'AMOUNT'], 'number'],
            [['LAST_UPDATE'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SEQ' => 'Seq',
            'CATEGORY' => 'Category',
            'FISCAL' => 'Fiscal',
            'NO' => 'No',
            'MODEL' => 'Model',
            'PERIOD' => 'Period',
            'QTY' => 'Qty',
            'AMOUNT' => 'Amount',
            'BU' => 'Bu',
            'TYPE' => 'Type',
            'LAST_UPDATE' => 'Last  Update',
        ];
    }




}
