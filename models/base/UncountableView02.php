<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.UNCOUNTABLE_VIEW_02".
 *
 * @property string $ITEM
 * @property string $ITEM_DESC
 * @property string $UOM
 * @property string $POST_DATE
 * @property double $ENDING_QTY
 * @property double $WH_ENDING_QTY
 * @property double $END_SAP_QTY
 * @property string $PERIOD
 * @property double $DEVIASI
 * @property double $DEVIASI_PERCENT
 * @property string $UPLOAD_DATE
 * @property string $aliasModel
 */
abstract class UncountableView02 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.UNCOUNTABLE_VIEW_02';
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
            [['ITEM', 'ITEM_DESC', 'UOM', 'PERIOD'], 'string'],
            [['POST_DATE', 'UPLOAD_DATE'], 'safe'],
            [['ENDING_QTY', 'WH_ENDING_QTY', 'END_SAP_QTY', 'DEVIASI', 'DEVIASI_PERCENT'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ITEM' => 'Item',
            'ITEM_DESC' => 'Item  Desc',
            'UOM' => 'Uom',
            'POST_DATE' => 'Post  Date',
            'ENDING_QTY' => 'Ending  Qty',
            'WH_ENDING_QTY' => 'Wh  Ending  Qty',
            'END_SAP_QTY' => 'End  Sap  Qty',
            'PERIOD' => 'Period',
            'DEVIASI' => 'Deviasi',
            'DEVIASI_PERCENT' => 'Deviasi  Percent',
            'UPLOAD_DATE' => 'Upload  Date',
        ];
    }




}
