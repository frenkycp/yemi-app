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
}
