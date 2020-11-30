<?php

namespace app\models;

use Yii;
use \app\models\base\SparepartMttrMtbf01 as BaseSparepartMttrMtbf01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SPAREPART_MTTR_MTBF_01".
 */
class SparepartMttrMtbf01 extends BaseSparepartMttrMtbf01
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
