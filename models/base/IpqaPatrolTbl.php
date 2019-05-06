<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.IPQA_PATROL_TBL".
 *
 * @property integer $id
 * @property string $period
 * @property string $event_date
 * @property string $gmc
 * @property string $model_name
 * @property string $color
 * @property string $destination
 * @property string $category
 * @property string $problem
 * @property string $description
 * @property string $inspector_id
 * @property string $inspector_name
 * @property string $line_pic
 * @property string $cause
 * @property string $countermeasure
 * @property integer $status
 * @property string $input_datetime
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
            [['period', 'gmc', 'model_name', 'color', 'destination', 'category', 'problem', 'description', 'inspector_id', 'inspector_name', 'line_pic', 'cause', 'countermeasure', 'filename1', 'closed_by', 'deleted_by', 'CC_ID', 'CC_GROUP', 'CC_DESC', 'child_analyst', 'child_analyst_desc', 'child', 'child_desc'], 'string'],
            [['event_date', 'input_datetime', 'close_datetime', 'delete_datetime'], 'safe'],
            [['status', 'flag'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'period' => 'Period',
            'event_date' => 'Event Date',
            'gmc' => 'Gmc',
            'model_name' => 'Model Name',
            'color' => 'Color',
            'destination' => 'Destination',
            'category' => 'Category',
            'problem' => 'Problem',
            'description' => 'Description',
            'inspector_id' => 'Inspector ID',
            'inspector_name' => 'Inspector Name',
            'line_pic' => 'Line Pic',
            'cause' => 'Cause',
            'countermeasure' => 'Countermeasure',
            'status' => 'Status',
            'input_datetime' => 'Input Datetime',
            'close_datetime' => 'Close Datetime',
            'delete_datetime' => 'Delete Datetime',
            'flag' => 'Flag',
            'filename1' => 'Filename1',
            'closed_by' => 'Closed By',
            'deleted_by' => 'Deleted By',
            'CC_ID' => 'Cc  ID',
            'CC_GROUP' => 'Cc  Group',
            'CC_DESC' => 'Cc  Desc',
            'child_analyst' => 'Child Analyst',
            'child_analyst_desc' => 'Child Analyst Desc',
            'child' => 'Child',
            'child_desc' => 'Child Desc',
        ];
    }




}
