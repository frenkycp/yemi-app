<?php

namespace app\models;

use Yii;
use \app\models\ProdNgData as BaseProdNgData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_TBL".
 */
class NgPaintingModel extends BaseProdNgData
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
                [['ng_qty', 'gmc_no', 'ng_category_id', 'post_date', 'ng_cause_category', 'model_group', 'pcb_ng_found'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                'part_desc' => 'NG Material',
                'pcb_id' => 'Part Number (WIP/Assy)',
                'ng_detail' => 'Remark',
                'gmc_no' => 'Model',
                'ng_category_id' => 'NG Name',
                'ng_qty' => 'NG Qty',
                'total_output' => 'Output',
                'post_date' => 'Process Date',
                'ng_cause_category' => 'Root Cause Category',
                'model_group' => 'Model Part',
                'pcb_ng_found' => 'NG Detected',
            ]
        );
    }
}
