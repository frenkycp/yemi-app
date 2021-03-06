<?php

namespace app\models;

use Yii;
use \app\models\base\PcbNg01 as BasePcbNg01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PCB_NG_01".
 */
class PcbNg01 extends BasePcbNg01
{
    public $defect_fa, $defect_fct_ict, $defect_mi, $defect_smt, $defect_ai;

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
}
