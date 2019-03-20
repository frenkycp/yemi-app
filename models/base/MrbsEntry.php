<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "mrbs_entry".
 *
 * @property integer $id
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $entry_type
 * @property integer $repeat_id
 * @property integer $room_id
 * @property string $timestamp
 * @property string $create_by
 * @property string $modified_by
 * @property string $name
 * @property string $type
 * @property string $description
 * @property integer $status
 * @property integer $reminded
 * @property integer $info_time
 * @property string $info_user
 * @property string $info_text
 * @property string $ical_uid
 * @property integer $ical_sequence
 * @property string $ical_recur_id
 * @property string $meeting_status
 *
 * @property \app\models\MrbsRoom $room
 * @property \app\models\MrbsRepeat $repeat
 * @property string $aliasModel
 */
abstract class MrbsEntry extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mrbs_entry';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mrbs');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time', 'entry_type', 'repeat_id', 'room_id', 'status', 'reminded', 'info_time', 'ical_sequence'], 'integer'],
            [['timestamp'], 'safe'],
            [['description', 'info_text'], 'string'],
            [['create_by', 'modified_by', 'info_user'], 'string', 'max' => 80],
            [['name'], 'string', 'max' => 500],
            [['type', 'meeting_status'], 'string', 'max' => 1],
            [['ical_uid'], 'string', 'max' => 255],
            [['ical_recur_id'], 'string', 'max' => 16],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\MrbsRoom::className(), 'targetAttribute' => ['room_id' => 'id']],
            [['repeat_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\MrbsRepeat::className(), 'targetAttribute' => ['repeat_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'entry_type' => 'Entry Type',
            'repeat_id' => 'Repeat ID',
            'room_id' => 'Room ID',
            'timestamp' => 'Timestamp',
            'create_by' => 'Create By',
            'modified_by' => 'Modified By',
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'status' => 'Status',
            'reminded' => 'Reminded',
            'info_time' => 'Info Time',
            'info_user' => 'Info User',
            'info_text' => 'Info Text',
            'ical_uid' => 'Ical Uid',
            'ical_sequence' => 'Ical Sequence',
            'ical_recur_id' => 'Ical Recur ID',
            'meeting_status' => 'Meeting Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(\app\models\MrbsRoom::className(), ['id' => 'room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepeat()
    {
        return $this->hasOne(\app\models\MrbsRepeat::className(), ['id' => 'repeat_id']);
    }




}
