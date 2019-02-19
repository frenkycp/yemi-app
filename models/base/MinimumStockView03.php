<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.MINIMUM_STOCK_VIEW_03".
 *
 * @property string $LOC_ITEM
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
 * @property double $ONHAND
 * @property double $PO
 * @property double $IMR
 * @property string $RACK
 * @property string $POST_DATE
 * @property integer $ONHAND_STATUS
 * @property string $ONHAND_STATUS_DESC
 * @property double $UNIT_PRICE
 * @property string $CURR
 * @property string $NIP_RCV
 * @property string $ACCOUNT
 * @property integer $LT
 * @property string $PR_COST_DEP
 * @property string $aliasModel
 */
abstract class MinimumStockView03 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.MINIMUM_STOCK_VIEW_03';
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
            [['LOC_ITEM', 'ITEM', 'ITEM_EQ_DESC_01', 'ITEM_EQ_UM', 'LOC', 'LOC_DESC', 'PIC', 'PIC_DESC', 'DEP', 'DEP_DESC', 'HIGH_RISK', 'CATEGORY', 'USER_ID', 'USER_DESC', 'MACHINE', 'MACHINE_NAME', 'RACK', 'ONHAND_STATUS_DESC', 'CURR', 'NIP_RCV', 'ACCOUNT', 'PR_COST_DEP'], 'string'],
            [['LOC', 'ONHAND', 'PO', 'IMR'], 'required'],
            [['MIN_STOCK_QTY', 'ONHAND', 'PO', 'IMR', 'UNIT_PRICE'], 'number'],
            [['LAST_UPDATE', 'POST_DATE'], 'safe'],
            [['ONHAND_STATUS', 'LT'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LOC_ITEM' => 'L O C I T E M',
            'ITEM' => 'I T E M',
            'ITEM_EQ_DESC_01' => 'I T E M E Q D E S C 01',
            'ITEM_EQ_UM' => 'I T E M E Q U M',
            'LOC' => 'L O C',
            'LOC_DESC' => 'L O C D E S C',
            'MIN_STOCK_QTY' => 'M I N S T O C K Q T Y',
            'PIC' => 'P I C',
            'PIC_DESC' => 'P I C D E S C',
            'DEP' => 'D E P',
            'DEP_DESC' => 'D E P D E S C',
            'HIGH_RISK' => 'H I G H R I S K',
            'CATEGORY' => 'C A T E G O R Y',
            'USER_ID' => 'U S E R I D',
            'USER_DESC' => 'U S E R D E S C',
            'LAST_UPDATE' => 'L A S T U P D A T E',
            'MACHINE' => 'M A C H I N E',
            'MACHINE_NAME' => 'M A C H I N E N A M E',
            'ONHAND' => 'O N H A N D',
            'PO' => 'P O',
            'IMR' => 'I M R',
            'RACK' => 'R A C K',
            'POST_DATE' => 'P O S T D A T E',
            'ONHAND_STATUS' => 'O N H A N D S T A T U S',
            'ONHAND_STATUS_DESC' => 'O N H A N D S T A T U S D E S C',
            'UNIT_PRICE' => 'U N I T P R I C E',
            'CURR' => 'C U R R',
            'NIP_RCV' => 'N I P R C V',
            'ACCOUNT' => 'A C C O U N T',
            'LT' => 'L T',
            'PR_COST_DEP' => 'P R C O S T D E P',
        ];
    }




}
