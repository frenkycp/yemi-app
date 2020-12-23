<?php

namespace app\models;

use Yii;
use \app\models\base\ProdNgData as BaseProdNgData;
use app\models\ProdNgPositionView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_TBL".
 */
class ProdNgData extends BaseProdNgData
{
    public $qty_ng_contract1, $qty_ng_contract2, $qty_ng_permanent, $ng_qty_1y_less, $ng_qty_1y_5y, $ng_qty_5y_over, $ng_total, $total_ng_all, $total_ng_sn, $total_ng_pa, $total_ng_piano, $total_ng_bo, $total_ng_av, $total_ng_dmi, $total_ng_other, $total_ng_null, $serno_record;

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

    public function getDiffMonth($date1, $date2)
    {
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        return $diff;
    }

    public function getWipName()
    {
        $wip_name = '';
        if ($this->pcb_id != null) {
            $wip_name = $this->pcb_id . ' | ' . $this->pcb_name;
        } else {
            $wip_name = $this->pcb_name;
        }
        return $wip_name;
    }

    public function getNgCategory()
    {
        return $this->ng_category_desc . ' | ' . $this->ng_category_detail;
    }

    public function getEmpDesc($value='')
    {
        if ($this->emp_id == null) {
            return '-';
        } else {
            return $this->emp_id . ' | ' . $this->emp_name;
        }
    }

    public function getSunfishEmp()
    {
        return $this->hasOne(SunfishViewEmp::className(), ['Emp_no' => 'emp_id']);
    }

    public function getDetailSerno()
    {
        return $this->hasMany(ProdNgDetailSerno::className(), ['document_no' => 'document_no']);
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
                //$ng_karyawan = Karyawan::find()->where(['NIK_SUN_FISH' => $this->emp_id])->one();
                $ng_karyawan = SunfishViewEmp::find()->where(['Emp_no' => $this->emp_id])->one();
                $this->emp_name = strtoupper($ng_karyawan->Full_name);
                $this->emp_gender = $ng_karyawan->gender;
                $this->emp_join_date = date('Y-m-d', strtotime($ng_karyawan->start_date));
                $this->emp_working_month = $this->getDiffMonth(date('Y-m-d', strtotime($ng_karyawan->start_date)), $this->post_date);
                $this->emp_status_code = $ng_karyawan->employ_code;
                if ($this->next_action == null) {
                    $this->action_status = 'O';
                } else {
                    $this->action_status = 'C';
                }
            } else {
                $this->emp_id = $this->emp_name = null;
                $this->action_status = 'C';
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
                    $tmp_sap = SapItemTbl::find()
                    ->where([
                        'material' => $this->pcb_id
                    ])
                    ->one();
                    if ($tmp_sap->material == null) {
                        $this->pcb_name = $this->pcb_id;
                        $this->pcb_id = null;
                    }
                    
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

            if ($this->ng_location_id != null) {
                $tmp_ng_position = ProdNgPositionView::find()->where(['ng_loc_id' => $this->ng_location_id])->one();
                $this->ng_location = $tmp_ng_position->position;
                $this->ng_category_id = $tmp_ng_position->ng_category_id;
                $this->ng_category_desc = $tmp_ng_position->category_name;
                $this->ng_category_detail = $tmp_ng_position->category_detail;
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
                        'WW03' => 'HL',
                        'WW02' => 'WW',
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

                if ($this->ng_cause_category == 'MAN') {
                    //$ng_karyawan = Karyawan::find()->where(['NIK_SUN_FISH' => $this->emp_id])->one();
                    $ng_karyawan = SunfishViewEmp::find()->where(['Emp_no' => $this->emp_id])->one();
                    $this->emp_name = strtoupper($ng_karyawan->Full_name);
                    $this->emp_gender = $ng_karyawan->gender;
                    $this->emp_join_date = date('Y-m-d', strtotime($ng_karyawan->start_date));
                    $this->emp_working_month = $this->getDiffMonth(date('Y-m-d', strtotime($ng_karyawan->start_date)), $this->post_date);
                    $this->emp_status_code = $ng_karyawan->employ_code;
                } else {
                    $this->emp_id = $this->emp_name = $this->emp_gender = $this->emp_join_date = $this->emp_working_month = $this->emp_status_code = null;
                    $this->next_action = null;
                }
            }
            return true;
        }
    }
}
