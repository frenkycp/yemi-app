<?php

namespace app\models;

use Yii;
use \app\models\base\MaskerIn as BaseMaskerIn;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_masker_in".
 */
class MaskerIn extends BaseMaskerIn
{
    public $total;

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
