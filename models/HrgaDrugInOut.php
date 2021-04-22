<?php

namespace app\models;

use Yii;
use \app\models\base\HrgaDrugInOut as BaseHrgaDrugInOut;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_drug_in_out".
 */
class HrgaDrugInOut extends BaseHrgaDrugInOut
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
