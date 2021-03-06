<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.ROOM_EVENT_TBL".
 *
 * @property integer $seq
 * @property integer $event_id
 * @property string $room_id
 * @property string $room_desc
 * @property string $room_event
 * @property string $start_time
 * @property string $end_time
 * @property integer $member_category
 * @property string $company
 * @property string $NIK
 * @property string $NAMA_KARYAWAN
 * @property string $CC_ID
 * @property string $DEPARTEMEN
 * @property string $SECTION
 * @property string $SUB_SECTION
 * @property string $user_id
 * @property string $user_desc
 * @property string $last_update
 * @property string $aliasModel
 */
abstract class RoomEventTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.ROOM_EVENT_TBL';
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
            [['event_id', 'member_category'], 'integer'],
            [['start_time', 'end_time', 'last_update'], 'safe'],
            [['room_id', 'CC_ID'], 'string', 'max' => 10],
            [['room_desc', 'company', 'NAMA_KARYAWAN', 'DEPARTEMEN', 'SECTION', 'SUB_SECTION', 'user_id'], 'string', 'max' => 50],
            [['room_event'], 'string', 'max' => 100],
            [['NIK'], 'string', 'max' => 20],
            [['user_desc'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'seq' => 'Seq',
            'event_id' => 'Event ID',
            'room_id' => 'Room ID',
            'room_desc' => 'Room Desc',
            'room_event' => 'Room Event',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'member_category' => 'Member Category',
            'company' => 'Company',
            'NIK' => 'Nik',
            'NAMA_KARYAWAN' => 'Nama Karyawan',
            'CC_ID' => 'Cc ID',
            'DEPARTEMEN' => 'Departemen',
            'SECTION' => 'Section',
            'SUB_SECTION' => 'Sub Section',
            'user_id' => 'User ID',
            'user_desc' => 'User Desc',
            'last_update' => 'Last Update',
        ];
    }




}
