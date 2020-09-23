<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SHIP_RESERVATION_DTR".
 *
 * @property string $BL_NO
 * @property string $RESERVATION_NO
 * @property string $HELP
 * @property string $STATUS
 * @property string $SHIPPER
 * @property string $POL
 * @property string $POD
 * @property double $CNT_40HC
 * @property double $CNT_40
 * @property double $CNT_20
 * @property string $CARRIER
 * @property integer $FLAG_PRIORTY
 * @property string $FLAG_DESC
 * @property string $ETD
 * @property string $APPLIED_RATE
 * @property string $INVOICE
 * @property string $NOTE
 * @property string $aliasModel
 */
abstract class ShipReservationDtr extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SHIP_RESERVATION_DTR';
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
            [['BL_NO', 'RESERVATION_NO'], 'required'],
            [['CNT_40HC', 'CNT_40', 'CNT_20'], 'number'],
            [['FLAG_PRIORTY'], 'integer'],
            [['ETD'], 'safe'],
            [['BL_NO', 'RESERVATION_NO', 'STATUS', 'SHIPPER', 'POL', 'POD', 'CARRIER', 'FLAG_DESC', 'INVOICE'], 'string', 'max' => 50],
            [['HELP'], 'string', 'max' => 1],
            [['APPLIED_RATE', 'NOTE'], 'string', 'max' => 100],
            [['BL_NO'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BL_NO' => 'Bl No',
            'RESERVATION_NO' => 'Reservation No',
            'HELP' => 'Help',
            'STATUS' => 'Status',
            'SHIPPER' => 'Shipper',
            'POL' => 'Pol',
            'POD' => 'Pod',
            'CNT_40HC' => 'Cnt 40 Hc',
            'CNT_40' => 'Cnt 40',
            'CNT_20' => 'Cnt 20',
            'CARRIER' => 'Carrier',
            'FLAG_PRIORTY' => 'Flag Priorty',
            'FLAG_DESC' => 'Flag Desc',
            'ETD' => 'Etd',
            'APPLIED_RATE' => 'Applied Rate',
            'INVOICE' => 'Invoice',
            'NOTE' => 'Note',
        ];
    }




}
