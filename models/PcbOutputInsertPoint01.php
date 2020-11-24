<?php

namespace app\models;

use Yii;
use \app\models\base\PcbOutputInsertPoint01 as BasePcbOutputInsertPoint01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PCB_OUTPUT_INSERT_POINT_01".
 */
class PcbOutputInsertPoint01 extends BasePcbOutputInsertPoint01
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
