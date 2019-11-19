<?php

namespace app\models;

use Yii;
use \app\models\base\MasalahSmt as BaseMasalahSmt;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_masalah_smt".
 */
class MasalahSmt extends BaseMasalahSmt
{
    public $total_ng;

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
