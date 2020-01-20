<?php

namespace app\models;

use Yii;
use \app\models\base\ProdNgData as BaseProdNgData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_TBL".
 */
class ProdNgData extends BaseProdNgData
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                'gmc_no' => 'Model',
                'pcb_name' => 'PCB',
                'pcb_side' => 'Side',
                'ng_qty' => 'NG Quantity',
                'pcb_problem' => 'Problem',
                'ng_root_cause' => 'Cause',
                'pcb_occu' => 'Occu',
                'pcb_part_section' => 'Part Section',
                'item_part' => 'Part Name',
            ]
        );
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            date_default_timezone_set('Asia/Jakarta');
            $now = date('Y-m-d H:i:s');

            $serno_master = SernoMaster::find()->where([
                'gmc' => $this->gmc_no
            ])->one();
            $this->gmc_model = $serno_master->model;
            $this->gmc_color = $serno_master->color;
            $this->gmc_dest = $serno_master->dest;
            $this->gmc_line = $serno_master->line;
            $this->gmc_desc = $serno_master->description;

            if ($this->ng_cause_category == 'MAN') {
                $ng_karyawan = Karyawan::find()->where(['NIK_SUN_FISH' => $this->emp_id])->one();
                $this->emp_name = $ng_karyawan->NAMA_KARYAWAN;
            } else {
                $this->emp_id = $this->emp_name = null;
            }

            $this->period = date('Ym', strtotime($this->post_date));

            $ng_category = ProdNgCategory::find()->where(['id' => $this->ng_category_id])->one();
            $this->ng_category_desc = $ng_category->category_name;
            $this->ng_category_detail = $ng_category->category_detail;

            if ($this->pcb_id != null) {
                $pcb_split_arr = explode(' | ', $this->pcb_id);
                if (count($pcb_split_arr) >= 2) {
                    $this->pcb_id = $pcb_split_arr[0];
                    $this->pcb_name = $pcb_split_arr[1];
                } else {
                    $this->pcb_name = $this->pcb_id;
                    $this->pcb_id = null;
                }
                
            }
            
            $this->part_desc = strtoupper($this->part_desc);

            if ($this->part_desc != null) {
                $part_desc_split = explode(' | ', $this->part_desc);
                if (count($part_desc_split) >= 2) {
                    $this->part_no = $part_desc_split[0];
                    $this->part_desc = $part_desc_split[1];
                }
            }
            

            if ($this->detected_by_id != null) {
                $detected_karyawan = Karyawan::find()->where(['NIK_SUN_FISH' => $this->detected_by_id])->one();
                $this->detected_by_name = $detected_karyawan->NAMA_KARYAWAN;
            }

            if ($this->smt_pic_aoi != null) {
                $smt_pic_aoi = Karyawan::find()->where(['NIK_SUN_FISH' => $this->smt_pic_aoi])->one();
                $this->smt_pic_aoi_name = $smt_pic_aoi->NAMA_KARYAWAN;
            }

            if ($this->smt_group_pic != null) {
                $smt_group_pic = Karyawan::find()->where(['NIK_SUN_FISH' => $this->smt_group_pic])->one();
                $this->smt_group_pic_name = $smt_group_pic->NAMA_KARYAWAN;
            }

            if ($this->ng_detail != null) {
                $this->ng_detail = strtoupper($this->ng_detail);
            }
            if ($this->ng_location != null) {
                $this->ng_location = strtoupper($this->ng_location);
            }
            

            if($this->isNewRecord)
            {
                if (in_array($this->loc_id, ['WI01', 'WI02', 'WI03'])) {
                    $count = ProdNgData::find()->where([
                        'post_date' => $this->post_date,
                        'loc_id' => ['WI01', 'WI02', 'WI03']
                    ])->count();
                    $count++;
                    $this->document_no = 'INJ' . date('Ymd', strtotime($this->post_date)) . str_pad($count, 3, '0', STR_PAD_LEFT);
                } else {
                    $count = ProdNgData::find()->where([
                        'post_date' => $this->post_date,
                        'loc_id' => $this->loc_id
                    ])->count();
                    $count++;
                    $arr_loc_doc = [
                        'WM01' => 'PCB',
                        'WU01' => 'SPU',
                        'WM03' => 'SMT',
                        'WF01' => 'FA',
                        'WP01' => 'PTG',
                    ];
                    $this->document_no = $arr_loc_doc[$this->loc_id] . date('Ymd', strtotime($this->post_date)) . str_pad($count, 3, '0', STR_PAD_LEFT);
                }

                $created_karyawan = Karyawan::find()->where([
                    'OR',
                    ['NIK_SUN_FISH' => \Yii::$app->user->identity->username],
                    ['NIK' => \Yii::$app->user->identity->username]
                ])->one();
                $this->created_time = $now;
                $this->created_by_id = $created_karyawan->NIK_SUN_FISH;
                $this->created_by_name = $created_karyawan->NAMA_KARYAWAN;

            } else {
                $updated_karyawan = Karyawan::find()->where([
                    'OR',
                    ['NIK_SUN_FISH' => \Yii::$app->user->identity->username],
                    ['NIK' => \Yii::$app->user->identity->username]
                ])->one();
                $this->updated_time = $now;
                $this->updated_by_id = $updated_karyawan->NIK_SUN_FISH;
                $this->updated_by_name = $updated_karyawan->NAMA_KARYAWAN;
            }
            return true;
        }
    }
}
