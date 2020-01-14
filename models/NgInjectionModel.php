<?php

namespace app\models;

use Yii;
use \app\models\base\ProdNgData as BaseProdNgData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_TBL".
 */
class NgInjectionModel extends BaseProdNgData
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
                [['ng_qty', 'part_desc', 'gmc_no', 'ng_category_id', 'line', 'post_date', 'ng_cause_category', 'ng_shift', 'inj_set_parameter', 'post_date'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                'part_desc' => 'Part Number',
                'ng_detail' => 'Remark',
                'gmc_no' => 'Model',
                'ng_category_id' => 'NG Name',
                'ng_qty' => 'NG Qty',
                'total_output' => 'Output',
                'post_date' => 'Created Proses',
                'ng_cause_category' => 'Root Cause Category',
                'inj_set_parameter' => 'Sett. Parameter',
                'ng_shift' => 'Shift',
            ]
        );
    }
}
