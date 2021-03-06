<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.WIP_EFF_VIEW".
 *
 * @property string $lot_id
 * @property string $LINE
 * @property string $SMT_SHIFT
 * @property string $KELOMPOK
 * @property string $slip_id_01
 * @property string $child_01
 * @property string $child_desc_01
 * @property double $act_qty_01
 * @property double $std_time_01
 * @property string $slip_id_02
 * @property string $child_02
 * @property string $child_desc_02
 * @property double $act_qty_02
 * @property double $std_time_02
 * @property string $slip_id_03
 * @property string $child_03
 * @property string $child_desc_03
 * @property double $act_qty_03
 * @property double $std_time_03
 * @property string $slip_id_04
 * @property string $child_04
 * @property string $child_desc_04
 * @property double $act_qty_04
 * @property double $std_time_04
 * @property string $slip_id_05
 * @property string $child_05
 * @property string $child_desc_05
 * @property double $act_qty_05
 * @property double $std_time_05
 * @property string $slip_id_06
 * @property string $child_06
 * @property string $child_desc_06
 * @property double $act_qty_06
 * @property double $std_time_06
 * @property string $slip_id_07
 * @property string $child_07
 * @property string $child_desc_07
 * @property double $act_qty_07
 * @property double $std_time_07
 * @property string $slip_id_08
 * @property string $child_08
 * @property string $child_desc_08
 * @property double $act_qty_08
 * @property double $std_time_08
 * @property string $slip_id_09
 * @property string $child_09
 * @property string $child_desc_09
 * @property double $act_qty_09
 * @property double $std_time_09
 * @property string $slip_id_10
 * @property string $child_10
 * @property string $child_desc_10
 * @property double $act_qty_10
 * @property double $std_time_10
 * @property double $qty_all
 * @property double $std_all
 * @property double $lt_gross
 * @property double $lt_loss
 * @property double $lt_nett
 * @property double $lt_std
 * @property double $efisiensi
 * @property string $start_date
 * @property string $end_date
 * @property string $post_date
 * @property string $period
 * @property double $long01
 * @property double $long02
 * @property double $long03
 * @property double $long04
 * @property double $long05
 * @property double $long06
 * @property double $long07
 * @property double $long08
 * @property double $long09
 * @property double $long10
 * @property double $long11
 * @property double $long12
 * @property double $long13
 * @property double $long14
 * @property double $long15
 * @property double $long16
 * @property double $long17
 * @property double $long18
 * @property double $long_total
 * @property double $break_time
 * @property double $nozzle_maintenance
 * @property double $change_schedule
 * @property double $air_pressure_problem
 * @property double $power_failure
 * @property double $part_shortage
 * @property double $set_up_1st_time_running_tp
 * @property double $part_arrangement_dcn
 * @property double $meeting
 * @property double $dandori
 * @property double $porgram_error
 * @property double $m_c_problem
 * @property double $feeder_problem
 * @property double $quality_problem
 * @property double $pcb_transfer_problem
 * @property double $profile_problem
 * @property double $pick_up_error
 * @property double $other
 * @property double $machine_warming_up
 * @property double $efisiensi_gross
 * @property string $child_analyst
 * @property string $child_analyst_desc
 * @property string $aliasModel
 */
abstract class WipEffView extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.WIP_EFF_VIEW';
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
            [['lot_id', 'machine_warming_up'], 'required'],
            [['lot_id', 'LINE', 'SMT_SHIFT', 'KELOMPOK', 'slip_id_01', 'child_01', 'child_desc_01', 'slip_id_02', 'child_02', 'child_desc_02', 'slip_id_03', 'child_03', 'child_desc_03', 'slip_id_04', 'child_04', 'child_desc_04', 'slip_id_05', 'child_05', 'child_desc_05', 'slip_id_06', 'child_06', 'child_desc_06', 'slip_id_07', 'child_07', 'child_desc_07', 'slip_id_08', 'child_08', 'child_desc_08', 'slip_id_09', 'child_09', 'child_desc_09', 'slip_id_10', 'child_10', 'child_desc_10', 'period', 'child_analyst', 'child_analyst_desc'], 'string'],
            [['act_qty_01', 'std_time_01', 'act_qty_02', 'std_time_02', 'act_qty_03', 'std_time_03', 'act_qty_04', 'std_time_04', 'act_qty_05', 'std_time_05', 'act_qty_06', 'std_time_06', 'act_qty_07', 'std_time_07', 'act_qty_08', 'std_time_08', 'act_qty_09', 'std_time_09', 'act_qty_10', 'std_time_10', 'qty_all', 'std_all', 'lt_gross', 'lt_loss', 'lt_nett', 'lt_std', 'efisiensi', 'long01', 'long02', 'long03', 'long04', 'long05', 'long06', 'long07', 'long08', 'long09', 'long10', 'long11', 'long12', 'long13', 'long14', 'long15', 'long16', 'long17', 'long18', 'long_total', 'break_time', 'nozzle_maintenance', 'change_schedule', 'air_pressure_problem', 'power_failure', 'part_shortage', 'set_up_1st_time_running_tp', 'part_arrangement_dcn', 'meeting', 'dandori', 'porgram_error', 'm_c_problem', 'feeder_problem', 'quality_problem', 'pcb_transfer_problem', 'profile_problem', 'pick_up_error', 'other', 'machine_warming_up', 'efisiensi_gross'], 'number'],
            [['start_date', 'end_date', 'post_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lot_id' => 'Lot ID',
            'LINE' => 'Line',
            'SMT_SHIFT' => 'Smt  Shift',
            'KELOMPOK' => 'Kelompok',
            'slip_id_01' => 'Slip Id 01',
            'child_01' => 'Child 01',
            'child_desc_01' => 'Child Desc 01',
            'act_qty_01' => 'Act Qty 01',
            'std_time_01' => 'Std Time 01',
            'slip_id_02' => 'Slip Id 02',
            'child_02' => 'Child 02',
            'child_desc_02' => 'Child Desc 02',
            'act_qty_02' => 'Act Qty 02',
            'std_time_02' => 'Std Time 02',
            'slip_id_03' => 'Slip Id 03',
            'child_03' => 'Child 03',
            'child_desc_03' => 'Child Desc 03',
            'act_qty_03' => 'Act Qty 03',
            'std_time_03' => 'Std Time 03',
            'slip_id_04' => 'Slip Id 04',
            'child_04' => 'Child 04',
            'child_desc_04' => 'Child Desc 04',
            'act_qty_04' => 'Act Qty 04',
            'std_time_04' => 'Std Time 04',
            'slip_id_05' => 'Slip Id 05',
            'child_05' => 'Child 05',
            'child_desc_05' => 'Child Desc 05',
            'act_qty_05' => 'Act Qty 05',
            'std_time_05' => 'Std Time 05',
            'slip_id_06' => 'Slip Id 06',
            'child_06' => 'Child 06',
            'child_desc_06' => 'Child Desc 06',
            'act_qty_06' => 'Act Qty 06',
            'std_time_06' => 'Std Time 06',
            'slip_id_07' => 'Slip Id 07',
            'child_07' => 'Child 07',
            'child_desc_07' => 'Child Desc 07',
            'act_qty_07' => 'Act Qty 07',
            'std_time_07' => 'Std Time 07',
            'slip_id_08' => 'Slip Id 08',
            'child_08' => 'Child 08',
            'child_desc_08' => 'Child Desc 08',
            'act_qty_08' => 'Act Qty 08',
            'std_time_08' => 'Std Time 08',
            'slip_id_09' => 'Slip Id 09',
            'child_09' => 'Child 09',
            'child_desc_09' => 'Child Desc 09',
            'act_qty_09' => 'Act Qty 09',
            'std_time_09' => 'Std Time 09',
            'slip_id_10' => 'Slip Id 10',
            'child_10' => 'Child 10',
            'child_desc_10' => 'Child Desc 10',
            'act_qty_10' => 'Act Qty 10',
            'std_time_10' => 'Std Time 10',
            'qty_all' => 'Qty All',
            'std_all' => 'Std All',
            'lt_gross' => 'Lt Gross',
            'lt_loss' => 'Lt Loss',
            'lt_nett' => 'Lt Nett',
            'lt_std' => 'Lt Std',
            'efisiensi' => 'Efisiensi',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'post_date' => 'Post Date',
            'period' => 'Period',
            'long01' => 'Long01',
            'long02' => 'Long02',
            'long03' => 'Long03',
            'long04' => 'Long04',
            'long05' => 'Long05',
            'long06' => 'Long06',
            'long07' => 'Long07',
            'long08' => 'Long08',
            'long09' => 'Long09',
            'long10' => 'Long10',
            'long11' => 'Long11',
            'long12' => 'Long12',
            'long13' => 'Long13',
            'long14' => 'Long14',
            'long15' => 'Long15',
            'long16' => 'Long16',
            'long17' => 'Long17',
            'long18' => 'Long18',
            'long_total' => 'Long Total',
            'break_time' => 'Break Time',
            'nozzle_maintenance' => 'Nozzle Maintenance',
            'change_schedule' => 'Change Schedule',
            'air_pressure_problem' => 'Air Pressure Problem',
            'power_failure' => 'Power Failure',
            'part_shortage' => 'Part Shortage',
            'set_up_1st_time_running_tp' => 'Set Up 1st Time Running Tp',
            'part_arrangement_dcn' => 'Part Arrangement Dcn',
            'meeting' => 'Meeting',
            'dandori' => 'Dandori',
            'porgram_error' => 'Porgram Error',
            'm_c_problem' => 'M C Problem',
            'feeder_problem' => 'Feeder Problem',
            'quality_problem' => 'Quality Problem',
            'pcb_transfer_problem' => 'Pcb Transfer Problem',
            'profile_problem' => 'Profile Problem',
            'pick_up_error' => 'Pick Up Error',
            'other' => 'Other',
            'machine_warming_up' => 'Machine Warming Up',
            'efisiensi_gross' => 'Efisiensi Gross',
            'child_analyst' => 'Child Analyst',
            'child_analyst_desc' => 'Child Analyst Desc',
        ];
    }




}
