<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.STORE_ONHAND".
 *
 * @property string $ITEM
 * @property string $ITEM_DESC
 * @property string $UM
 * @property double $ONHAND_QTY
 * @property string $PI_DUMMY
 * @property string $aliasModel
 */
abstract class StoreOnhandWsus extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.STORE_ONHAND';
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
            [['ITEM'], 'required'],
            [['ITEM', 'ITEM_DESC', 'UM', 'PI_DUMMY'], 'string'],
            [['ONHAND_QTY'], 'number'],
            [['ITEM'], 'unique']
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
            'UM' => 'Um',
            'ONHAND_QTY' => 'Onhand  Qty',
            'PI_DUMMY' => 'Pi  Dummy',
        ];
    }




}
