<?php

namespace app\models;

use Yii;
use \app\models\base\FaMp01 as BaseFaMp01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "fa_mp_01".
 */
class FaMp01 extends BaseFaMp01
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
