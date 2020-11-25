<?php

namespace app\models;

use Yii;
use \app\models\base\PcbInsertPointData as BasePcbInsertPointData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PCB_INSERT_POINT_DATA".
 */
class PcbInsertPointData extends BasePcbInsertPointData
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
            parent::attributeLabels(),
            [
                'part_no' => 'Part No',
                'model_name' => 'Model Name',
                'pcb' => 'Pcb',
                'destination' => 'Destination',
                'smt_a' => 'SMT A',
                'smt_b' => 'SMT B',
                'smt' => 'SMT',
                'jv2' => 'JV2',
                'av131' => 'AV131',
                'rg131' => 'RG131',
                'ai' => 'AI',
                'mi' => 'MI',
                'total' => 'Total',
                'price' => 'Price',
                'last_update' => 'Last Update',
                'bu' => 'BU',
            ]
        );
    }

    public static function primaryKey()
    {
        return ["part_no"];
    }
}
