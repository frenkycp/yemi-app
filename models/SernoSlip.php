<?php

namespace app\models;

use Yii;
use \app\models\base\SernoSlip as BaseSernoSlip;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_slip".
 */
class SernoSlip extends BaseSernoSlip
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
