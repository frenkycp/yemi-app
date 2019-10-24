<?php

namespace app\models;

use Yii;
use \app\models\base\FaMp02 as BaseFaMp02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "fa_mp_02".
 */
class FaMp02 extends BaseFaMp02
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
