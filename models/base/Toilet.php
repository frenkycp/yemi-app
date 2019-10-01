<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.TOILET".
 *
 * @property string $room_id
 * @property string $room_desc
 * @property integer $room_value
 * @property string $last_update
 * @property string $start_date
 * @property string $end_date
 * @property double $lt_second
 * @property string $aliasModel
 */
abstract class Toilet extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.TOILET';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_iot');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_id'], 'required'],
            [['room_value'], 'integer'],
            [['last_update', 'start_date', 'end_date'], 'safe'],
            [['lt_second'], 'number'],
            [['room_id', 'room_desc'], 'string', 'max' => 50],
            [['room_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'room_id' => 'Room ID',
            'room_desc' => 'Room Desc',
            'room_value' => 'Room Value',
            'last_update' => 'Last Update',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'lt_second' => 'Lt Second',
        ];
    }




}
