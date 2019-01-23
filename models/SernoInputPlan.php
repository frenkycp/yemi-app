<?php

namespace app\models;

use Yii;
use \app\models\base\SernoInputPlan as BaseSernoInputPlan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_input_plan".
 */
class SernoInputPlan extends BaseSernoInputPlan
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
