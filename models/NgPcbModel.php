<?php

namespace app\models;

use Yii;
use \app\models\ProdNgData as BaseProdNgData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_TBL".
 */
class NgPcbModel extends BaseProdNgData
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
                [['gmc_no', 'pcb_id', 'pcb_ng_found', 'pcb_side', 'ng_qty', 'ng_category_id', 'pcb_occu', 'pcb_process', 'line', 'pcb_part_section', 'part_desc', 'ng_location', 'detected_by_id', 'pcb_repair', 'ng_cause_category'], 'required'],
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
                'pcb_id' => 'PCB',
                'pcb_ng_found' => 'NG Found',
                'ng_category_id' => 'Problem',
                'pcb_process' => 'Process',
                'part_desc' => 'Part Name',
                'ng_location' => 'Location',
                'detected_by_id' => 'DETECTED',
                'pcb_repair' => 'Repair',
                'ng_cause_category' => 'Root Cause Category',
            ]
        );
    }
}
