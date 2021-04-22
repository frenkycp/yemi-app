<?php

namespace app\models;

use Yii;
use \app\models\base\HrgaDrugMaster as BaseHrgaDrugMaster;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_drug_master".
 */
class HrgaDrugMaster extends BaseHrgaDrugMaster
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
}
