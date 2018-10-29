<?php

namespace app\models;

use Yii;
use \app\models\base\SernoLosstime as BaseSernoLosstime;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_losstime".
 */
class SernoLosstime extends BaseSernoLosstime
{
    public $period;

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
