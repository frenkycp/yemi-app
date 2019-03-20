<?php

namespace app\models;

use Yii;
use \app\models\base\MrbsRepeat as BaseMrbsRepeat;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "mrbs_repeat".
 */
class MrbsRepeat extends BaseMrbsRepeat
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
