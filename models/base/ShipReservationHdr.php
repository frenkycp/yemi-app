<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.SHIP_RESERVATION_HDR".
 *
 * @property string $RESERVATION_NO
 * @property string $RESERVATION_REMARK
 * @property string $aliasModel
 */
abstract class ShipReservationHdr extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.SHIP_RESERVATION_HDR';
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
            [['RESERVATION_NO'], 'required'],
            [['RESERVATION_NO'], 'string', 'max' => 50],
            [['RESERVATION_REMARK'], 'string', 'max' => 150],
            [['RESERVATION_NO'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'RESERVATION_NO' => 'Reservation No',
            'RESERVATION_REMARK' => 'Reservation Remark',
        ];
    }




}
