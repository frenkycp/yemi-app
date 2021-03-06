<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SHIPPING_ORDER_NEW_01".
 *
 * @property string $PERIOD
 * @property string $ETD
 * @property string $ETD_SUB
 * @property string $POD
 * @property string $STATUS
 * @property integer $TOTAL_COUNT
 * @property integer $CNT_40HC
 * @property integer $CNT_40
 * @property integer $CNT_20
 * @property integer $LCL
 * @property string $aliasModel
 */
abstract class ShippingOrderNew01 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SHIPPING_ORDER_NEW_01';
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
            [['ETD', 'ETD_SUB'], 'safe'],
            [['TOTAL_COUNT', 'CNT_40HC', 'CNT_40', 'CNT_20', 'LCL'], 'integer'],
            [['CNT_40HC', 'CNT_40', 'CNT_20', 'LCL'], 'required'],
            [['PERIOD', 'POD', 'STATUS'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PERIOD' => 'Period',
            'ETD' => 'Etd',
            'ETD_SUB' => 'Etd Sub',
            'POD' => 'Pod',
            'STATUS' => 'Status',
            'TOTAL_COUNT' => 'Total Count',
            'CNT_40HC' => 'Cnt 40 Hc',
            'CNT_40' => 'Cnt 40',
            'CNT_20' => 'Cnt 20',
            'LCL' => 'Lcl',
        ];
    }




}
