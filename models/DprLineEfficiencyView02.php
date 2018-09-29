<?php

namespace app\models;

use Yii;
use \app\models\base\DprLineEfficiencyView02 as BaseDprLineEfficiencyView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dpr_line_efficiency_view_02".
 */
class DprLineEfficiencyView02 extends BaseDprLineEfficiencyView02
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
