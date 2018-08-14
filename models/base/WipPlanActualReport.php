<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.WIP_PLAN_ACTUAL_REPORT".
 *
 * @property string $period
 * @property integer $week
 * @property string $slip_id
 * @property string $child_analyst
 * @property string $child_analyst_desc
 * @property string $model_group
 * @property string $parent
 * @property string $parent_desc
 * @property string $child
 * @property string $child_desc
 * @property string $start_date
 * @property string $due_date
 * @property string $post_date
 * @property string $start_job
 * @property string $end_job
 * @property double $summary_qty
 * @property string $stage
 * @property string $problem
 * @property string $slip_id_reference
 * @property string $fullfilment_stat
 * @property string $source_date
 * @property string $upload_id
 * @property string $period_line
 * @property integer $session_id
 * @property string $aliasModel
 */
abstract class WipPlanActualReport extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.WIP_PLAN_ACTUAL_REPORT';
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
            [['period', 'slip_id', 'child_analyst', 'child_analyst_desc', 'model_group', 'parent', 'parent_desc', 'child', 'child_desc', 'stage', 'problem', 'slip_id_reference', 'fullfilment_stat', 'upload_id', 'period_line'], 'string'],
            [['week', 'session_id'], 'integer'],
            [['start_date', 'due_date', 'post_date', 'start_job', 'end_job', 'source_date'], 'safe'],
            [['summary_qty'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period' => 'Period',
            'week' => 'Week',
            'slip_id' => 'Slip ID',
            'child_analyst' => 'Child Analyst',
            'child_analyst_desc' => 'Child Analyst Desc',
            'model_group' => 'Model Group',
            'parent' => 'Parent',
            'parent_desc' => 'Parent Desc',
            'child' => 'Child',
            'child_desc' => 'Child Desc',
            'start_date' => 'Start Date',
            'due_date' => 'Due Date',
            'post_date' => 'Post Date',
            'start_job' => 'Start Job',
            'end_job' => 'End Job',
            'summary_qty' => 'Summary Qty',
            'stage' => 'Stage',
            'problem' => 'Problem',
            'slip_id_reference' => 'Slip Id Reference',
            'fullfilment_stat' => 'Fullfilment Stat',
            'source_date' => 'Source Date',
            'upload_id' => 'Upload ID',
            'period_line' => 'Period Line',
            'session_id' => 'Session ID',
        ];
    }




}
