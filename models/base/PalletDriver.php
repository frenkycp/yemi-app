<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tb_pallet_driver".
 *
 * @property string $nik
 * @property string $driver_name
 * @property string $order_from
 * @property string $last_update
 * @property integer $todays_point
 * @property integer $driver_status
 * @property integer $driver_type
 * @property integer $factory
 * @property string $aliasModel
 */
abstract class PalletDriver extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pallet_driver';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mis7');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nik'], 'required'],
            [['last_update'], 'safe'],
            [['todays_point', 'driver_status', 'driver_type', 'factory'], 'integer'],
            [['nik', 'order_from'], 'string', 'max' => 10],
            [['driver_name'], 'string', 'max' => 150],
            [['nik'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nik' => 'Nik',
            'driver_name' => 'Driver Name',
            'order_from' => 'Order From',
            'last_update' => 'Last Update',
            'todays_point' => 'Todays Point',
            'driver_status' => 'Driver Status',
            'driver_type' => 'Driver Type',
            'factory' => 'Factory',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'driver_type' => '1 = GOPALLET; 2 = GOSHOP',
        ]);
    }




}
