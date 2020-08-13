<?php

namespace app\models;

use Yii;
use \app\models\base\DrossInput as BaseDrossInput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "input_tm".
 */
class DrossInput extends BaseDrossInput
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
