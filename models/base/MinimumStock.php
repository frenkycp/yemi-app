<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.MINIMUM_STOCK".
 *
 * @property string $ID_ITEM_LOC
 * @property string $ITEM
 * @property string $ITEM_EQ_DESC_01
 * @property string $ITEM_EQ_UM
 * @property string $LOC
 * @property string $LOC_DESC
 * @property double $MIN_STOCK_QTY
 * @property string $PIC
 * @property string $PIC_DESC
 * @property string $DEP
 * @property string $DEP_DESC
 * @property string $HIGH_RISK
 * @property string $CATEGORY
 * @property string $USER_ID
 * @property string $USER_DESC
 * @property string $LAST_UPDATE
 * @property string $MACHINE
 * @property string $MACHINE_NAME
 * @property string $aliasModel
 */
abstract class MinimumStock extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.MINIMUM_STOCK';
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
            [['ID_ITEM_LOC', 'LOC'], 'required'],
            [['ID_ITEM_LOC', 'ITEM', 'ITEM_EQ_DESC_01', 'ITEM_EQ_UM', 'LOC', 'LOC_DESC', 'PIC', 'PIC_DESC', 'DEP', 'DEP_DESC', 'HIGH_RISK', 'CATEGORY', 'USER_ID', 'USER_DESC', 'MACHINE', 'MACHINE_NAME'], 'string'],
            [['MIN_STOCK_QTY'], 'number'],
            [['LAST_UPDATE'], 'safe'],
            [['ID_ITEM_LOC'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_ITEM_LOC' => 'Id  Item  Loc',
            'ITEM' => 'Item',
            'ITEM_EQ_DESC_01' => 'Item  Eq  Desc 01',
            'ITEM_EQ_UM' => 'Item  Eq  Um',
            'LOC' => 'Loc',
            'LOC_DESC' => 'Loc  Desc',
            'MIN_STOCK_QTY' => 'Min  Stock  Qty',
            'PIC' => 'Pic',
            'PIC_DESC' => 'Pic  Desc',
            'DEP' => 'Dep',
            'DEP_DESC' => 'Dep  Desc',
            'HIGH_RISK' => 'High  Risk',
            'CATEGORY' => 'Category',
            'USER_ID' => 'User  ID',
            'USER_DESC' => 'User  Desc',
            'LAST_UPDATE' => 'Last  Update',
            'MACHINE' => 'Machine',
            'MACHINE_NAME' => 'Machine  Name',
        ];
    }




}
