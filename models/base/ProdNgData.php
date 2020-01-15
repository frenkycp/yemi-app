<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.PROD_NG_TBL".
 *
 * @property integer $id
 * @property string $document_no
 * @property string $period
 * @property string $post_date
 * @property string $loc_id
 * @property string $loc_desc
 * @property string $line
 * @property string $emp_id
 * @property string $emp_name
 * @property string $model_group
 * @property string $gmc_no
 * @property string $gmc_desc
 * @property string $gmc_model
 * @property string $gmc_color
 * @property string $gmc_dest
 * @property string $gmc_line
 * @property string $part_no
 * @property string $part_desc
 * @property double $ng_qty
 * @property double $total_output
 * @property integer $ng_category_id
 * @property string $ng_category_desc
 * @property string $ng_category_detail
 * @property integer $ng_shift
 * @property string $ng_location
 * @property string $ng_root_cause
 * @property string $ng_detail
 * @property string $ng_cause_category
 * @property string $created_time
 * @property string $created_by_id
 * @property string $created_by_name
 * @property string $updated_time
 * @property string $updated_by_id
 * @property string $updated_by_name
 * @property string $detected_by_id
 * @property string $detected_by_name
 * @property string $attachment
 * @property integer $inj_set_parameter
 * @property string $fa_area_detec
 * @property string $fa_serno
 * @property string $fa_status
 * @property string $pcb_id
 * @property string $pcb_name
 * @property string $pcb_ng_found
 * @property string $pcb_side
 * @property string $pcb_problem
 * @property string $pcb_occu
 * @property string $pcb_process
 * @property string $pcb_part_section
 * @property string $pcb_pic
 * @property string $pcb_repair
 * @property string $smt_group
 * @property string $smt_pic_aoi
 * @property string $smt_pic_aoi_name
 * @property string $smt_group_pic
 * @property string $smt_group_pic_name
 * @property string $ww_unit_each
 * @property double $ww_total_price
 * @property string $aliasModel
 */
abstract class ProdNgData extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.PROD_NG_TBL';
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
            [['post_date', 'created_time', 'updated_time'], 'safe'],
            [['ng_qty', 'total_output', 'ww_total_price'], 'number'],
            [['ng_category_id', 'ng_shift', 'inj_set_parameter'], 'integer'],
            [['document_no', 'loc_desc', 'ng_category_desc', 'ng_category_detail', 'ng_location', 'ng_root_cause', 'attachment', 'pcb_ng_found', 'pcb_side', 'pcb_problem', 'pcb_occu', 'pcb_process', 'pcb_part_section', 'pcb_pic', 'pcb_repair', 'smt_pic_aoi', 'smt_group_pic'], 'string', 'max' => 50],
            [['period', 'loc_id', 'fa_status'], 'string', 'max' => 10],
            [['line', 'emp_id', 'model_group', 'gmc_no', 'gmc_color', 'gmc_dest', 'gmc_line', 'part_no', 'ng_cause_category', 'created_by_id', 'updated_by_id', 'detected_by_id', 'fa_area_detec'], 'string', 'max' => 20],
            [['emp_name', 'gmc_desc', 'gmc_model', 'ng_detail', 'created_by_name', 'updated_by_name', 'detected_by_name', 'smt_pic_aoi_name', 'smt_group_pic_name'], 'string', 'max' => 150],
            [['part_desc'], 'string', 'max' => 250],
            [['fa_serno', 'ww_unit_each'], 'string', 'max' => 30],
            [['pcb_id', 'pcb_name'], 'string', 'max' => 200],
            [['smt_group'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_no' => 'Document No',
            'period' => 'Period',
            'post_date' => 'Post Date',
            'loc_id' => 'Loc ID',
            'loc_desc' => 'Loc Desc',
            'line' => 'Line',
            'emp_id' => 'Emp ID',
            'emp_name' => 'Emp Name',
            'model_group' => 'Model Group',
            'gmc_no' => 'Gmc No',
            'gmc_desc' => 'Gmc Desc',
            'gmc_model' => 'Gmc Model',
            'gmc_color' => 'Gmc Color',
            'gmc_dest' => 'Gmc Dest',
            'gmc_line' => 'Gmc Line',
            'part_no' => 'Part No',
            'part_desc' => 'Part Desc',
            'ng_qty' => 'Ng Qty',
            'total_output' => 'Total Output',
            'ng_category_id' => 'Ng Category ID',
            'ng_category_desc' => 'Ng Category Desc',
            'ng_category_detail' => 'Ng Category Detail',
            'ng_shift' => 'Ng Shift',
            'ng_location' => 'Ng Location',
            'ng_root_cause' => 'Ng Root Cause',
            'ng_detail' => 'Ng Detail',
            'ng_cause_category' => 'Ng Cause Category',
            'created_time' => 'Created Time',
            'created_by_id' => 'Created By ID',
            'created_by_name' => 'Created By Name',
            'updated_time' => 'Updated Time',
            'updated_by_id' => 'Updated By ID',
            'updated_by_name' => 'Updated By Name',
            'detected_by_id' => 'Detected By ID',
            'detected_by_name' => 'Detected By Name',
            'attachment' => 'Attachment',
            'inj_set_parameter' => 'Inj Set Parameter',
            'fa_area_detec' => 'Fa Area Detec',
            'fa_serno' => 'Fa Serno',
            'fa_status' => 'Fa Status',
            'pcb_id' => 'Pcb ID',
            'pcb_name' => 'Pcb Name',
            'pcb_ng_found' => 'Pcb Ng Found',
            'pcb_side' => 'Pcb Side',
            'pcb_problem' => 'Pcb Problem',
            'pcb_occu' => 'Pcb Occu',
            'pcb_process' => 'Pcb Process',
            'pcb_part_section' => 'Pcb Part Section',
            'pcb_pic' => 'Pcb Pic',
            'pcb_repair' => 'Pcb Repair',
            'smt_group' => 'Smt Group',
            'smt_pic_aoi' => 'Smt Pic Aoi',
            'smt_pic_aoi_name' => 'Smt Pic Aoi Name',
            'smt_group_pic' => 'Smt Group Pic',
            'smt_group_pic_name' => 'Smt Group Pic Name',
            'ww_unit_each' => 'Ww Unit Each',
            'ww_total_price' => 'Ww Total Price',
        ];
    }




}
