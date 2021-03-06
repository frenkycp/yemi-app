<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.WIP_EFF_TBL".
 *
 * @property string $lot_id
 * @property string $child_analyst
 * @property string $child_analyst_desc
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
 * @property string $child_all
 * @property string $child_desc_all
 * @property double $qty_all
 * @property double $std_all
 * @property double $lt_gross
 * @property double $lt_loss
 * @property double $lt_nett
 * @property double $lt_std
 * @property double $efisiensi_gross
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
 * @property double $long19
 * @property double $long20
 * @property double $long21
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
 * @property double $engineering_sample
 * @property double $service_parts
 * @property string $USER_ID
 * @property string $USER_DESC
 * @property string $LAST_UPDATE
 * @property string $note01
 * @property string $note02
 * @property string $note03
 * @property string $note04
 * @property string $note05
 * @property string $note06
 * @property string $note07
 * @property string $note08
 * @property string $note09
 * @property string $note10
 * @property string $note11
 * @property string $note12
 * @property string $note13
 * @property string $note14
 * @property string $note15
 * @property string $note16
 * @property string $note17
 * @property string $note18
 * @property string $note19
 * @property string $post_date_original
 * @property string $period_original
 * @property string $plan_item
 * @property double $plan_qty
 * @property string $plan_date
 * @property double $plan_balance
 * @property string $plan_stats
 * @property string $plan_run
 * @property double $slip_count
 * @property string $mesin_id
 * @property string $mesin_description
 * @property string $jenis_mesin
 * @property string $model_group
 * @property string $parent
 * @property string $parent_desc
 * @property integer $ext_dandori_status
 * @property string $ext_dandori_start
 * @property string $ext_dandori_end
 * @property string $ext_dandori_handover
 * @property integer $ext_dandori_lt
 * @property string $ext_dandori_nik
 * @property string $ext_dandori_name
 * @property string $ext_dandori_end_nik
 * @property string $ext_dandori_end_name
 * @property string $ext_dandori_handover_nik
 * @property string $ext_dandori_handover_name
 * @property string $ext_dandori_last_update
 * @property integer $carriage_total
 * @property integer $carriage_finish
 * @property integer $carriage_open
 * @property double $ng_qty
 * @property string $aliasModel
 */
abstract class WipEffTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.WIP_EFF_TBL';
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
            [['lot_id'], 'required'],
            [['act_qty_01', 'std_time_01', 'act_qty_02', 'std_time_02', 'act_qty_03', 'std_time_03', 'act_qty_04', 'std_time_04', 'act_qty_05', 'std_time_05', 'act_qty_06', 'std_time_06', 'act_qty_07', 'std_time_07', 'act_qty_08', 'std_time_08', 'act_qty_09', 'std_time_09', 'act_qty_10', 'std_time_10', 'qty_all', 'std_all', 'lt_gross', 'lt_loss', 'lt_nett', 'lt_std', 'efisiensi_gross', 'efisiensi', 'long01', 'long02', 'long03', 'long04', 'long05', 'long06', 'long07', 'long08', 'long09', 'long10', 'long11', 'long12', 'long13', 'long14', 'long15', 'long16', 'long17', 'long18', 'long19', 'long20', 'long21', 'long_total', 'break_time', 'nozzle_maintenance', 'change_schedule', 'air_pressure_problem', 'power_failure', 'part_shortage', 'set_up_1st_time_running_tp', 'part_arrangement_dcn', 'meeting', 'dandori', 'porgram_error', 'm_c_problem', 'feeder_problem', 'quality_problem', 'pcb_transfer_problem', 'profile_problem', 'pick_up_error', 'other', 'machine_warming_up', 'engineering_sample', 'service_parts', 'plan_qty', 'plan_balance', 'slip_count', 'ng_qty'], 'number'],
            [['start_date', 'end_date', 'post_date', 'LAST_UPDATE', 'post_date_original', 'plan_date', 'ext_dandori_start', 'ext_dandori_end', 'ext_dandori_handover', 'ext_dandori_last_update'], 'safe'],
            [['ext_dandori_status', 'ext_dandori_lt', 'carriage_total', 'carriage_finish', 'carriage_open'], 'integer'],
            [['lot_id', 'child_analyst_desc', 'KELOMPOK', 'child_desc_01', 'child_desc_02', 'child_desc_03', 'child_desc_04', 'child_desc_05', 'child_desc_06', 'child_desc_07', 'child_desc_08', 'child_desc_09', 'child_desc_10', 'child_desc_all', 'USER_DESC', 'mesin_id', 'jenis_mesin', 'model_group', 'ext_dandori_name', 'ext_dandori_end_name', 'ext_dandori_handover_name'], 'string', 'max' => 50],
            [['child_analyst', 'period', 'period_original'], 'string', 'max' => 6],
            [['LINE'], 'string', 'max' => 13],
            [['SMT_SHIFT', 'parent'], 'string', 'max' => 20],
            [['slip_id_01', 'slip_id_02', 'slip_id_03', 'slip_id_04', 'slip_id_05', 'slip_id_06', 'slip_id_07', 'slip_id_08', 'slip_id_09', 'slip_id_10', 'USER_ID', 'ext_dandori_nik', 'ext_dandori_end_nik', 'ext_dandori_handover_nik'], 'string', 'max' => 10],
            [['child_01', 'child_02', 'child_03', 'child_04', 'child_05', 'child_06', 'child_07', 'child_08', 'child_09', 'child_10', 'child_all', 'plan_item'], 'string', 'max' => 15],
            [['note01', 'note02', 'note03', 'note04', 'note05', 'note06', 'note07', 'note08', 'note09', 'note10', 'note11', 'note12', 'note13', 'note14', 'note15', 'note16', 'note17', 'note18', 'note19'], 'string', 'max' => 255],
            [['plan_stats', 'plan_run'], 'string', 'max' => 1],
            [['mesin_description'], 'string', 'max' => 100],
            [['parent_desc'], 'string', 'max' => 250],
            [['lot_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lot_id' => 'Lot ID',
            'child_analyst' => 'Child Analyst',
            'child_analyst_desc' => 'Child Analyst Desc',
            'LINE' => 'Line',
            'SMT_SHIFT' => 'Smt Shift',
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
            'child_all' => 'Child All',
            'child_desc_all' => 'Child Desc All',
            'qty_all' => 'Qty All',
            'std_all' => 'Std All',
            'lt_gross' => 'Lt Gross',
            'lt_loss' => 'Lt Loss',
            'lt_nett' => 'Lt Nett',
            'lt_std' => 'Lt Std',
            'efisiensi_gross' => 'Efisiensi Gross',
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
            'long19' => 'Long19',
            'long20' => 'Long20',
            'long21' => 'Long21',
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
            'engineering_sample' => 'Engineering Sample',
            'service_parts' => 'Service Parts',
            'USER_ID' => 'User ID',
            'USER_DESC' => 'User Desc',
            'LAST_UPDATE' => 'Last Update',
            'note01' => 'Note01',
            'note02' => 'Note02',
            'note03' => 'Note03',
            'note04' => 'Note04',
            'note05' => 'Note05',
            'note06' => 'Note06',
            'note07' => 'Note07',
            'note08' => 'Note08',
            'note09' => 'Note09',
            'note10' => 'Note10',
            'note11' => 'Note11',
            'note12' => 'Note12',
            'note13' => 'Note13',
            'note14' => 'Note14',
            'note15' => 'Note15',
            'note16' => 'Note16',
            'note17' => 'Note17',
            'note18' => 'Note18',
            'note19' => 'Note19',
            'post_date_original' => 'Post Date Original',
            'period_original' => 'Period Original',
            'plan_item' => 'Plan Item',
            'plan_qty' => 'Plan Qty',
            'plan_date' => 'Plan Date',
            'plan_balance' => 'Plan Balance',
            'plan_stats' => 'Plan Stats',
            'plan_run' => 'Plan Run',
            'slip_count' => 'Slip Count',
            'mesin_id' => 'Mesin ID',
            'mesin_description' => 'Mesin Description',
            'jenis_mesin' => 'Jenis Mesin',
            'model_group' => 'Model Group',
            'parent' => 'Parent',
            'parent_desc' => 'Parent Desc',
            'ext_dandori_status' => 'Ext Dandori Status',
            'ext_dandori_start' => 'Ext Dandori Start',
            'ext_dandori_end' => 'Ext Dandori End',
            'ext_dandori_handover' => 'Ext Dandori Handover',
            'ext_dandori_lt' => 'Ext Dandori Lt',
            'ext_dandori_nik' => 'Ext Dandori Nik',
            'ext_dandori_name' => 'Ext Dandori Name',
            'ext_dandori_end_nik' => 'Ext Dandori End Nik',
            'ext_dandori_end_name' => 'Ext Dandori End Name',
            'ext_dandori_handover_nik' => 'Ext Dandori Handover Nik',
            'ext_dandori_handover_name' => 'Ext Dandori Handover Name',
            'ext_dandori_last_update' => 'Ext Dandori Last Update',
            'carriage_total' => 'Carriage Total',
            'carriage_finish' => 'Carriage Finish',
            'carriage_open' => 'Carriage Open',
            'ng_qty' => 'Ng Qty',
        ];
    }




}
