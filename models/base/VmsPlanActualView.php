<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.VMS_PLAN_ACTUAL_VIEW".
 *
 * @property string $ID
 * @property string $ID_PERIOD
 * @property string $PRODUCT_TYPE
 * @property string $BU
 * @property string $LINE
 * @property string $MODEL
 * @property string $FG_KD
 * @property string $ITEM
 * @property string $ITEM_DESC
 * @property string $DESTINATION
 * @property string $VMS_PERIOD
 * @property string $VMS_DAY
 * @property string $VMS_DATE
 * @property double $PLAN_QTY
 * @property double $ACTUAL_QTY
 * @property double $BALANCE_QTY
 * @property string $VMS_VERSION
 * @property integer $SEESION_NO
 * @property string $SESSION_DATE
 * @property string $ACT_QTY_LAST_UPDATE
 * @property string $LINE_LAST_UPDATE
 * @property string $PCUT
 * @property string $NOTE
 * @property string $aliasModel
 */
abstract class VmsPlanActualView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.VMS_PLAN_ACTUAL_VIEW';
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
            [['VMS_DATE', 'SESSION_DATE', 'ACT_QTY_LAST_UPDATE', 'LINE_LAST_UPDATE'], 'safe'],
            [['PLAN_QTY', 'ACTUAL_QTY', 'BALANCE_QTY'], 'number'],
            [['SEESION_NO'], 'integer'],
            [['NOTE'], 'string'],
            [['ID', 'ID_PERIOD', 'PRODUCT_TYPE', 'BU', 'LINE', 'MODEL', 'FG_KD', 'ITEM_DESC', 'DESTINATION', 'VMS_PERIOD', 'VMS_DAY', 'VMS_VERSION', 'PCUT'], 'string', 'max' => 50],
            [['ITEM'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_PERIOD' => 'Id Period',
            'PRODUCT_TYPE' => 'Product Type',
            'BU' => 'Bu',
            'LINE' => 'Line',
            'MODEL' => 'Model',
            'FG_KD' => 'Fg Kd',
            'ITEM' => 'Item',
            'ITEM_DESC' => 'Item Desc',
            'DESTINATION' => 'Destination',
            'VMS_PERIOD' => 'Vms Period',
            'VMS_DAY' => 'Vms Day',
            'VMS_DATE' => 'Vms Date',
            'PLAN_QTY' => 'Plan Qty',
            'ACTUAL_QTY' => 'Actual Qty',
            'BALANCE_QTY' => 'Balance Qty',
            'VMS_VERSION' => 'Vms Version',
            'SEESION_NO' => 'Seesion No',
            'SESSION_DATE' => 'Session Date',
            'ACT_QTY_LAST_UPDATE' => 'Act Qty Last Update',
            'LINE_LAST_UPDATE' => 'Line Last Update',
            'PCUT' => 'Pcut',
            'NOTE' => 'Note',
        ];
    }




}
