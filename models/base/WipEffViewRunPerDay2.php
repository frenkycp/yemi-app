<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.WIP_EFF_VIEW_RUN_PER_DAY2".
 *
 * @property string $LINE
 * @property string $post_date
 * @property string $period
 * @property double $break_time_second
 * @property double $nozzle_maintenance_second
 * @property double $change_schedule_second
 * @property double $air_pressure_problem_second
 * @property double $power_failure_second
 * @property double $part_shortage_second
 * @property double $set_up_1st_time_running_tp_second
 * @property double $part_arrangement_dcn_second
 * @property double $meeting_second
 * @property double $dandori_second
 * @property double $porgram_error_second
 * @property double $m_c_problem_second
 * @property double $feeder_problem_second
 * @property double $quality_problem_second
 * @property double $pcb_transfer_problem_second
 * @property double $profile_problem_second
 * @property double $pick_up_error_second
 * @property double $other_second
 * @property integer $shift_second
 * @property integer $shift_count
 * @property integer $day_second
 * @property double $machine_run_second_2
 * @property double $total_iddle_second
 * @property integer $machine_off
 * @property string $aliasModel
 */
abstract class WipEffViewRunPerDay2 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.WIP_EFF_VIEW_RUN_PER_DAY2';
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
            [['LINE', 'period'], 'string'],
            [['post_date'], 'safe'],
            [['break_time_second', 'nozzle_maintenance_second', 'change_schedule_second', 'air_pressure_problem_second', 'power_failure_second', 'part_shortage_second', 'set_up_1st_time_running_tp_second', 'part_arrangement_dcn_second', 'meeting_second', 'dandori_second', 'porgram_error_second', 'm_c_problem_second', 'feeder_problem_second', 'quality_problem_second', 'pcb_transfer_problem_second', 'profile_problem_second', 'pick_up_error_second', 'other_second', 'machine_run_second_2', 'total_iddle_second'], 'number'],
            [['shift_second', 'shift_count', 'day_second', 'machine_off'], 'integer'],
            [['day_second'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LINE' => 'Line',
            'post_date' => 'Post Date',
            'period' => 'Period',
            'break_time_second' => 'Break Time Second',
            'nozzle_maintenance_second' => 'Nozzle Maintenance Second',
            'change_schedule_second' => 'Change Schedule Second',
            'air_pressure_problem_second' => 'Air Pressure Problem Second',
            'power_failure_second' => 'Power Failure Second',
            'part_shortage_second' => 'Part Shortage Second',
            'set_up_1st_time_running_tp_second' => 'Set Up 1st Time Running Tp Second',
            'part_arrangement_dcn_second' => 'Part Arrangement Dcn Second',
            'meeting_second' => 'Meeting Second',
            'dandori_second' => 'Dandori Second',
            'porgram_error_second' => 'Porgram Error Second',
            'm_c_problem_second' => 'M C Problem Second',
            'feeder_problem_second' => 'Feeder Problem Second',
            'quality_problem_second' => 'Quality Problem Second',
            'pcb_transfer_problem_second' => 'Pcb Transfer Problem Second',
            'profile_problem_second' => 'Profile Problem Second',
            'pick_up_error_second' => 'Pick Up Error Second',
            'other_second' => 'Other Second',
            'shift_second' => 'Shift Second',
            'shift_count' => 'Shift Count',
            'day_second' => 'Day Second',
            'machine_run_second_2' => 'Machine Run Second 2',
            'total_iddle_second' => 'Total Iddle Second',
            'machine_off' => 'Machine Off',
        ];
    }




}
