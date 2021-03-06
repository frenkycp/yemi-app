<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.ONHAND_NICE".
 *
 * @property string $SEQ
 * @property string $ITEM
 * @property string $ITEM_DESC
 * @property string $UM
 * @property double $ONHAND_QTY
 * @property double $item_m3
 * @property double $TOT_M3
 * @property string $PIC
 * @property string $RACK
 * @property string $RACK_LOC
 * @property string $LAST_UPDATE
 * @property string $aliasModel
 */
abstract class OnhandNice extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.ONHAND_NICE';
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
            [['ONHAND_QTY', 'item_m3', 'TOT_M3'], 'number'],
            [['LAST_UPDATE'], 'safe'],
            [['ITEM'], 'string', 'max' => 13],
            [['ITEM_DESC'], 'string', 'max' => 50],
            [['UM'], 'string', 'max' => 3],
            [['PIC', 'RACK', 'RACK_LOC'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SEQ' => 'Seq',
            'ITEM' => 'Item',
            'ITEM_DESC' => 'Item Desc',
            'UM' => 'Um',
            'ONHAND_QTY' => 'Onhand Qty',
            'item_m3' => 'Item M3',
            'TOT_M3' => 'Tot M3',
            'PIC' => 'Pic',
            'RACK' => 'Rack',
            'RACK_LOC' => 'Rack Loc',
            'LAST_UPDATE' => 'Last Update',
        ];
    }




}
