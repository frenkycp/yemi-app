<?php

namespace app\models;

use Yii;
use \app\models\ProdNgData as BaseProdNgData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_TBL".
 */
class NgSmtModel extends BaseProdNgData
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
                [['ng_qty', 'pcb_id', 'gmc_no', 'ng_category_id', 'line', 'post_date', 'ng_cause_category', 'pcb_side', 'smt_group', 'smt_pic_aoi', 'smt_group_pic', 'ng_location'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                'pcb_id' => 'Part No (WIP/Assy)',
                'part_desc' => 'Part Name',
                'smt_group' => 'Group',
                'pcb_side' => 'Side',
                'ng_detail' => 'Remark',
                'gmc_no' => 'Model',
                'ng_category_id' => 'Cause',
                'ng_qty' => 'NG Qty',
                'total_output' => 'Output',
                'post_date' => 'Created Proses',
                'ng_cause_category' => 'Root Cause Category',
                'smt_pic_aoi' => 'PIC AOI',
                'smt_group_pic' => 'PIC Group',
                'ng_location' => 'Location',
            ]
        );
    }
}
