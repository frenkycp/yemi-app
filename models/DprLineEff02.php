<?php

namespace app\models;

use Yii;
use \app\models\base\DprLineEff02 as BaseDprLineEff02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dpr_line_eff02".
 */
class DprLineEff02 extends BaseDprLineEff02
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
