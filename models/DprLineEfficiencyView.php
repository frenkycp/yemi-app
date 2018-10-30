<?php

namespace app\models;

use Yii;
use \app\models\base\DprLineEfficiencyView as BaseDprLineEfficiencyView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dpr_line_efficiency_view".
 */
class DprLineEfficiencyView extends BaseDprLineEfficiencyView
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
