<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "mrbs_repeat".
 *
 * @property integer $id
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $rep_type
 * @property integer $end_date
 * @property string $rep_opt
 * @property integer $room_id
 * @property string $timestamp
 * @property string $create_by
 * @property string $modified_by
 * @property string $name
 * @property string $type
 * @property string $description
 * @property integer $rep_num_weeks
 * @property integer $month_absolute
 * @property string $month_relative
 * @property integer $status
 * @property integer $reminded
 * @property integer $info_time
 * @property string $info_user
 * @property string $info_text
 * @property string $ical_uid
 * @property integer $ical_sequence
 * @property string $meeting_status
 *
 * @property \app\models\MrbsEntry[] $mrbsEntries
 * @property \app\models\MrbsRoom $room
 * @property string $aliasModel
 */
abstract class MrbsRepeat extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mrbs_repeat';
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
            [['start_time', 'end_time', 'rep_type', 'end_date', 'room_id', 'rep_num_weeks', 'month_absolute', 'status', 'reminded', 'info_time', 'ical_sequence'], 'integer'],
            [['timestamp'], 'safe'],
            [['description', 'info_text'], 'string'],
            [['rep_opt'], 'string', 'max' => 32],
            [['create_by', 'modified_by', 'name', 'info_user'], 'string', 'max' => 80],
            [['type', 'meeting_status'], 'string', 'max' => 1],
            [['month_relative'], 'string', 'max' => 4],
            [['ical_uid'], 'string', 'max' => 255],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\MrbsRoom::className(), 'targetAttribute' => ['room_id' => 'id']]
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
            'rep_type' => 'Rep Type',
            'end_date' => 'End Date',
            'rep_opt' => 'Rep Opt',
            'room_id' => 'Room ID',
            'timestamp' => 'Timestamp',
            'create_by' => 'Create By',
            'modified_by' => 'Modified By',
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rep_num_weeks' => 'Rep Num Weeks',
            'month_absolute' => 'Month Absolute',
            'month_relative' => 'Month Relative',
            'status' => 'Status',
            'reminded' => 'Reminded',
            'info_time' => 'Info Time',
            'info_user' => 'Info User',
            'info_text' => 'Info Text',
            'ical_uid' => 'Ical Uid',
            'ical_sequence' => 'Ical Sequence',
            'meeting_status' => 'Meeting Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMrbsEntries()
    {
        return $this->hasMany(\app\models\MrbsEntry::className(), ['repeat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(\app\models\MrbsRoom::className(), ['id' => 'room_id']);
    }




}
