<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.WIP_HDR_DTR_BU".
 *
 * @property string $dtr_id
 * @property string $hdr_id_item
 * @property string $hdr_id
 * @property string $upload_id
 * @property string $period
 * @property string $period_line
 * @property string $child_analyst
 * @property string $child_analyst_desc
 * @property string $child
 * @property string $child_desc
 * @property string $model_group
 * @property string $parent
 * @property string $parent_desc
 * @property string $start_date
 * @property string $due_date
 * @property string $post_date
 * @property double $plan_qty
 * @property double $act_qty
 * @property double $balance_by_day
 * @property double $balance_by_day_2
 * @property double $balance_by_completed_day
 * @property double $plan_acc_qty
 * @property double $act_acc_qty
 * @property double $balance_acc_qty
 * @property string $urut
 * @property string $slip_id
 * @property double $plan_qty_hdr
 * @property double $act_qty_hdr
 * @property double $balance_qty_hdr
 * @property double $child_fx_lt
 * @property double $child_dts_lt
 * @property double $balance_act_qty
 * @property string $stage
 * @property string $created_date
 * @property string $start_job
 * @property string $end_job
 * @property string $hand_over_job
 * @property string $slip_id_barcode_label
 * @property string $source_date
 * @property string $created_user_id
 * @property string $created_user_desc
 * @property string $start_job_user_id
 * @property string $start_job_user_desc
 * @property string $end_job_user_id
 * @property string $end_job_user_desc
 * @property string $hand_over_job_user_id
 * @property string $hand_over_job_user_desc
 * @property string $order_release_date
 * @property string $order_release_user_id
 * @property string $order_release_user_desc
 * @property string $start_cancel_job
 * @property string $start_cancel_job_user_id
 * @property string $start_cancel_job_user_desc
 * @property string $end_cancel_job
 * @property string $end_cancel_job_user_id
 * @property string $end_cancel_job_user_desc
 * @property double $source_qty
 * @property string $stat
 * @property string $slip_id_reference
 * @property string $problem
 * @property string $fullfilment_stat
 * @property string $ipc_ok_ng
 * @property string $ipc_in_id
 * @property string $ipc_ok_ng_desc
 * @property string $ipc_in_id_user_desc
 * @property double $ipc_in_qty
 * @property string $ipc_close_id
 * @property string $ipc_close_id_user_desc
 * @property double $lt_ipc
 * @property double $lt_started
 * @property double $lt_completed
 * @property double $lt_handover
 * @property string $calculated_close
 * @property string $recreate_close
 * @property double $bom_level
 * @property integer $session_id
 * @property string $hdr_id_item_due_date
 * @property string $re_handover_close
 * @property string $repair_job
 * @property string $repair_job_user_id
 * @property string $repair_job_user_desc
 * @property string $hand_over_cancel_job
 * @property string $hand_over_cancel_job_user_id
 * @property string $hand_over_cancel_job_user_desc
 * @property string $note
 * @property double $gojek_req_qty
 * @property string $completed_split_id
 * @property string $completed_split_desc
 * @property string $completed_split
 * @property double $std_time
 * @property double $std_time_x_act_qty
 * @property string $reservation
 * @property string $reservation_number
 * @property string $delay_category
 * @property string $delay_detail
 * @property string $delay_userid
 * @property string $delay_userid_desc
 * @property string $delay_last_update
 * @property double $ORDER_QTY
 * @property double $COMMIT_QTY
 * @property double $OUSTANDING_QTY
 * @property double $CREATED_QTY
 * @property double $STARTED_QTY
 * @property double $COMPLETED_QTY
 * @property double $HAND_OVER_QTY
 * @property string $fa_lot_no
 * @property double $fa_lot_qty
 * @property string $LINE
 * @property string $aliasModel
 */
abstract class WipHdrDtrBu extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.WIP_HDR_DTR_BU';
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
            [['hdr_id_item'], 'required'],
            [['start_date', 'due_date', 'post_date', 'created_date', 'start_job', 'end_job', 'hand_over_job', 'source_date', 'order_release_date', 'start_cancel_job', 'end_cancel_job', 'repair_job', 'hand_over_cancel_job', 'completed_split', 'delay_last_update'], 'safe'],
            [['plan_qty', 'act_qty', 'balance_by_day', 'balance_by_day_2', 'balance_by_completed_day', 'plan_acc_qty', 'act_acc_qty', 'balance_acc_qty', 'plan_qty_hdr', 'act_qty_hdr', 'balance_qty_hdr', 'child_fx_lt', 'child_dts_lt', 'balance_act_qty', 'source_qty', 'ipc_in_qty', 'lt_ipc', 'lt_started', 'lt_completed', 'lt_handover', 'bom_level', 'gojek_req_qty', 'std_time', 'std_time_x_act_qty', 'ORDER_QTY', 'COMMIT_QTY', 'OUSTANDING_QTY', 'CREATED_QTY', 'STARTED_QTY', 'COMPLETED_QTY', 'HAND_OVER_QTY', 'fa_lot_qty'], 'number'],
            [['ipc_ok_ng_desc'], 'string'],
            [['session_id'], 'integer'],
            [['dtr_id'], 'string', 'max' => 100],
            [['hdr_id_item', 'hdr_id', 'upload_id', 'child_analyst_desc', 'child_desc', 'model_group', 'parent_desc', 'stage', 'created_user_desc', 'start_job_user_desc', 'end_job_user_desc', 'hand_over_job_user_desc', 'order_release_user_desc', 'start_cancel_job_user_desc', 'end_cancel_job_user_desc', 'fullfilment_stat', 'ipc_in_id_user_desc', 'ipc_close_id_user_desc', 'hdr_id_item_due_date', 'repair_job_user_desc', 'hand_over_cancel_job_user_desc', 'note', 'completed_split_desc', 'reservation_number', 'delay_category', 'delay_userid_desc', 'fa_lot_no', 'LINE'], 'string', 'max' => 50],
            [['period', 'child_analyst'], 'string', 'max' => 6],
            [['period_line'], 'string', 'max' => 4],
            [['child', 'parent'], 'string', 'max' => 15],
            [['urut'], 'string', 'max' => 2],
            [['slip_id', 'created_user_id', 'start_job_user_id', 'end_job_user_id', 'hand_over_job_user_id', 'order_release_user_id', 'start_cancel_job_user_id', 'end_cancel_job_user_id', 'slip_id_reference', 'ipc_in_id', 'ipc_close_id', 'repair_job_user_id', 'hand_over_cancel_job_user_id', 'completed_split_id', 'delay_userid'], 'string', 'max' => 10],
            [['slip_id_barcode_label', 'delay_detail'], 'string', 'max' => 255],
            [['stat', 'problem', 'ipc_ok_ng', 'calculated_close', 'recreate_close', 're_handover_close', 'reservation'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dtr_id' => 'Dtr ID',
            'hdr_id_item' => 'Hdr Id Item',
            'hdr_id' => 'Hdr ID',
            'upload_id' => 'Upload ID',
            'period' => 'Period',
            'period_line' => 'Period Line',
            'child_analyst' => 'Child Analyst',
            'child_analyst_desc' => 'Child Analyst Desc',
            'child' => 'Child',
            'child_desc' => 'Child Desc',
            'model_group' => 'Model Group',
            'parent' => 'Parent',
            'parent_desc' => 'Parent Desc',
            'start_date' => 'Start Date',
            'due_date' => 'Due Date',
            'post_date' => 'Post Date',
            'plan_qty' => 'Plan Qty',
            'act_qty' => 'Act Qty',
            'balance_by_day' => 'Balance By Day',
            'balance_by_day_2' => 'Balance By Day 2',
            'balance_by_completed_day' => 'Balance By Completed Day',
            'plan_acc_qty' => 'Plan Acc Qty',
            'act_acc_qty' => 'Act Acc Qty',
            'balance_acc_qty' => 'Balance Acc Qty',
            'urut' => 'Urut',
            'slip_id' => 'Slip ID',
            'plan_qty_hdr' => 'Plan Qty Hdr',
            'act_qty_hdr' => 'Act Qty Hdr',
            'balance_qty_hdr' => 'Balance Qty Hdr',
            'child_fx_lt' => 'Child Fx Lt',
            'child_dts_lt' => 'Child Dts Lt',
            'balance_act_qty' => 'Balance Act Qty',
            'stage' => 'Stage',
            'created_date' => 'Created Date',
            'start_job' => 'Start Job',
            'end_job' => 'End Job',
            'hand_over_job' => 'Hand Over Job',
            'slip_id_barcode_label' => 'Slip Id Barcode Label',
            'source_date' => 'Source Date',
            'created_user_id' => 'Created User ID',
            'created_user_desc' => 'Created User Desc',
            'start_job_user_id' => 'Start Job User ID',
            'start_job_user_desc' => 'Start Job User Desc',
            'end_job_user_id' => 'End Job User ID',
            'end_job_user_desc' => 'End Job User Desc',
            'hand_over_job_user_id' => 'Hand Over Job User ID',
            'hand_over_job_user_desc' => 'Hand Over Job User Desc',
            'order_release_date' => 'Order Release Date',
            'order_release_user_id' => 'Order Release User ID',
            'order_release_user_desc' => 'Order Release User Desc',
            'start_cancel_job' => 'Start Cancel Job',
            'start_cancel_job_user_id' => 'Start Cancel Job User ID',
            'start_cancel_job_user_desc' => 'Start Cancel Job User Desc',
            'end_cancel_job' => 'End Cancel Job',
            'end_cancel_job_user_id' => 'End Cancel Job User ID',
            'end_cancel_job_user_desc' => 'End Cancel Job User Desc',
            'source_qty' => 'Source Qty',
            'stat' => 'Stat',
            'slip_id_reference' => 'Slip Id Reference',
            'problem' => 'Problem',
            'fullfilment_stat' => 'Fullfilment Stat',
            'ipc_ok_ng' => 'Ipc Ok Ng',
            'ipc_in_id' => 'Ipc In ID',
            'ipc_ok_ng_desc' => 'Ipc Ok Ng Desc',
            'ipc_in_id_user_desc' => 'Ipc In Id User Desc',
            'ipc_in_qty' => 'Ipc In Qty',
            'ipc_close_id' => 'Ipc Close ID',
            'ipc_close_id_user_desc' => 'Ipc Close Id User Desc',
            'lt_ipc' => 'Lt Ipc',
            'lt_started' => 'Lt Started',
            'lt_completed' => 'Lt Completed',
            'lt_handover' => 'Lt Handover',
            'calculated_close' => 'Calculated Close',
            'recreate_close' => 'Recreate Close',
            'bom_level' => 'Bom Level',
            'session_id' => 'Session ID',
            'hdr_id_item_due_date' => 'Hdr Id Item Due Date',
            're_handover_close' => 'Re Handover Close',
            'repair_job' => 'Repair Job',
            'repair_job_user_id' => 'Repair Job User ID',
            'repair_job_user_desc' => 'Repair Job User Desc',
            'hand_over_cancel_job' => 'Hand Over Cancel Job',
            'hand_over_cancel_job_user_id' => 'Hand Over Cancel Job User ID',
            'hand_over_cancel_job_user_desc' => 'Hand Over Cancel Job User Desc',
            'note' => 'Note',
            'gojek_req_qty' => 'Gojek Req Qty',
            'completed_split_id' => 'Completed Split ID',
            'completed_split_desc' => 'Completed Split Desc',
            'completed_split' => 'Completed Split',
            'std_time' => 'Std Time',
            'std_time_x_act_qty' => 'Std Time X Act Qty',
            'reservation' => 'Reservation',
            'reservation_number' => 'Reservation Number',
            'delay_category' => 'Delay Category',
            'delay_detail' => 'Delay Detail',
            'delay_userid' => 'Delay Userid',
            'delay_userid_desc' => 'Delay Userid Desc',
            'delay_last_update' => 'Delay Last Update',
            'ORDER_QTY' => 'Order Qty',
            'COMMIT_QTY' => 'Commit Qty',
            'OUSTANDING_QTY' => 'Oustanding Qty',
            'CREATED_QTY' => 'Created Qty',
            'STARTED_QTY' => 'Started Qty',
            'COMPLETED_QTY' => 'Completed Qty',
            'HAND_OVER_QTY' => 'Hand Over Qty',
            'fa_lot_no' => 'Fa Lot No',
            'fa_lot_qty' => 'Fa Lot Qty',
            'LINE' => 'Line',
        ];
    }




}
