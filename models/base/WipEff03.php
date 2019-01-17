<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.WIP_EFF_03".
 *
 * @property string $period
 * @property string $post_date
 * @property string $hari
 * @property string $child_analyst
 * @property string $child_analyst_desc
 * @property string $LINE
 * @property string $SMT_SHIFT
 * @property string $child_01
 * @property string $child_desc_01
 * @property double $std_all
 * @property double $qty_all
 * @property double $machine_run_std_second
 * @property integer $machine_run_act_second
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
 * @property double $loss_planned
 * @property double $loss_out_section
 * @property double $loss_in_section
 * @property double $loss_planned_outsection
 * @property double $total_lost
 * @property double $machine_utilization
 * @property double $gross_minus_planned_loss
 * @property double $nett1_minus_planned_outsection_loss
 * @property double $nett2_minus_all_loss
 * @property double $efisiensi_working_ratio
 * @property string $aliasModel
 */
abstract class WipEff03 extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.WIP_EFF_03';
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
            [['period', 'hari', 'child_analyst', 'child_analyst_desc', 'LINE', 'SMT_SHIFT', 'child_01', 'child_desc_01'], 'string'],
            [['post_date'], 'safe'],
            [['std_all', 'qty_all', 'machine_run_std_second', 'break_time_second', 'nozzle_maintenance_second', 'change_schedule_second', 'air_pressure_problem_second', 'power_failure_second', 'part_shortage_second', 'set_up_1st_time_running_tp_second', 'part_arrangement_dcn_second', 'meeting_second', 'dandori_second', 'porgram_error_second', 'm_c_problem_second', 'feeder_problem_second', 'quality_problem_second', 'pcb_transfer_problem_second', 'profile_problem_second', 'pick_up_error_second', 'other_second', 'loss_planned', 'loss_out_section', 'loss_in_section', 'loss_planned_outsection', 'total_lost', 'machine_utilization', 'gross_minus_planned_loss', 'nett1_minus_planned_outsection_loss', 'nett2_minus_all_loss', 'efisiensi_working_ratio'], 'number'],
            [['machine_run_act_second'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period' => 'Period',
            'post_date' => 'Post Date',
            'hari' => 'Hari',
            'child_analyst' => 'Child Analyst',
            'child_analyst_desc' => 'Child Analyst Desc',
            'LINE' => 'Line',
            'SMT_SHIFT' => 'Smt  Shift',
            'child_01' => 'Child 01',
            'child_desc_01' => 'Child Desc 01',
            'std_all' => 'Std All',
            'qty_all' => 'Qty All',
            'machine_run_std_second' => 'Machine Run Std Second',
            'machine_run_act_second' => 'Machine Run Act Second',
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
            'loss_planned' => 'Loss Planned',
            'loss_out_section' => 'Loss Out Section',
            'loss_in_section' => 'Loss In Section',
            'loss_planned_outsection' => 'Loss Planned Outsection',
            'total_lost' => 'Total Lost',
            'machine_utilization' => 'Machine Utilization',
            'gross_minus_planned_loss' => 'Gross Minus Planned Loss',
            'nett1_minus_planned_outsection_loss' => 'Nett1 Minus Planned Outsection Loss',
            'nett2_minus_all_loss' => 'Nett2 Minus All Loss',
            'efisiensi_working_ratio' => 'Efisiensi Working Ratio',
        ];
    }




}
