<?php

namespace app\models;

use Yii;
use \app\models\base\SernoCnt as BaseSernoCnt;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_cnt".
 */
class SernoCnt extends BaseSernoCnt
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
