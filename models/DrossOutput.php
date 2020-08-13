<?php

namespace app\models;

use Yii;
use \app\models\base\DrossOutput as BaseDrossOutput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "out_dross".
 */
class DrossOutput extends BaseDrossOutput
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
