<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.IPQA_PATROL_TBL".
 *
 * @property integer $id
 * @property string $case_no
 * @property string $period
 * @property string $event_date
 * @property string $category
 * @property string $problem
 * @property string $description
 * @property string $inspector_id
 * @property string $inspector_name
 * @property string $line_pic
 * @property string $cause
 * @property string $countermeasure
 * @property string $due_date
 * @property integer $status
 * @property string $input_datetime
 * @property string $reply_datetime
 * @property string $close_datetime
 * @property string $delete_datetime
 * @property integer $flag
 * @property string $filename1
 * @property string $closed_by
 * @property string $deleted_by
 * @property string $CC_ID
 * @property string $CC_GROUP
 * @property string $CC_DESC
 * @property string $child_analyst
 * @property string $child_analyst_desc
 * @property string $child
 * @property string $child_desc
 * @property string $fa_line
 * @property string $replied_by_id
 * @property string $replied_by_name
 * @property string $closed_by_id
 * @property string $closed_by_name
 * @property string $deleted_by_id
 * @property string $deleted_by_name
 * @property string $reject_remark
 * @property string $reject_answer
 * @property string $rank_category
 * @property string $aliasModel
 */
abstract class IpqaPatrolTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.IPQA_PATROL_TBL';
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
            [['event_date', 'due_date', 'input_datetime', 'reply_datetime', 'close_datetime', 'delete_datetime'], 'safe'],
            [['description', 'cause', 'countermeasure', 'reject_remark', 'reject_answer'], 'string'],
            [['status', 'flag'], 'integer'],
            [['case_no'], 'string', 'max' => 20],
            [['period'], 'string', 'max' => 7],
            [['category', 'inspector_id', 'CC_ID', 'child', 'replied_by_id', 'closed_by_id', 'deleted_by_id', 'rank_category'], 'string', 'max' => 10],
            [['problem', 'deleted_by', 'child_desc', 'replied_by_name', 'closed_by_name', 'deleted_by_name'], 'string', 'max' => 200],
            [['inspector_name'], 'string', 'max' => 150],
            [['line_pic', 'CC_GROUP', 'CC_DESC', 'child_analyst', 'fa_line'], 'string', 'max' => 50],
            [['filename1', 'closed_by', 'child_analyst_desc'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'case_no' => 'Case No',
            'period' => 'Period',
            'event_date' => 'Event Date',
            'category' => 'Category',
            'problem' => 'Problem',
            'description' => 'Description',
            'inspector_id' => 'Inspector ID',
            'inspector_name' => 'Inspector Name',
            'line_pic' => 'Line Pic',
            'cause' => 'Cause',
            'countermeasure' => 'Countermeasure',
            'due_date' => 'Due Date',
            'status' => 'Status',
            'input_datetime' => 'Input Datetime',
            'reply_datetime' => 'Reply Datetime',
            'close_datetime' => 'Close Datetime',
            'delete_datetime' => 'Delete Datetime',
            'flag' => 'Flag',
            'filename1' => 'Filename1',
            'closed_by' => 'Closed By',
            'deleted_by' => 'Deleted By',
            'CC_ID' => 'Cc ID',
            'CC_GROUP' => 'Cc Group',
            'CC_DESC' => 'Cc Desc',
            'child_analyst' => 'Child Analyst',
            'child_analyst_desc' => 'Child Analyst Desc',
            'child' => 'Child',
            'child_desc' => 'Child Desc',
            'fa_line' => 'Fa Line',
            'replied_by_id' => 'Replied By ID',
            'replied_by_name' => 'Replied By Name',
            'closed_by_id' => 'Closed By ID',
            'closed_by_name' => 'Closed By Name',
            'deleted_by_id' => 'Deleted By ID',
            'deleted_by_name' => 'Deleted By Name',
            'reject_remark' => 'Reject Remark',
            'reject_answer' => 'Reject Answer',
            'rank_category' => 'Rank Category',
        ];
    }




}
