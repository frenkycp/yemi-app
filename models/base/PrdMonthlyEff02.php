<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.PRD_MONTHLY_EFF_02".
 *
 * @property string $PERIOD
 * @property string $ITEM
 * @property string $ITEM_DESC
 * @property double $TOTAL_QTY
 * @property double $STD_TOTAL
 * @property double $TOTAL_ST
 * @property string $aliasModel
 */
abstract class PrdMonthlyEff02 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.PRD_MONTHLY_EFF_02';
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
            [['TOTAL_QTY', 'STD_TOTAL', 'TOTAL_ST'], 'number'],
            [['PERIOD', 'ITEM_DESC'], 'string', 'max' => 50],
            [['ITEM'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PERIOD' => 'Period',
            'ITEM' => 'Item',
            'ITEM_DESC' => 'Item Desc',
            'TOTAL_QTY' => 'Total Qty',
            'STD_TOTAL' => 'Std Total',
            'TOTAL_ST' => 'Total St',
        ];
    }




}
