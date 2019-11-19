<?php

namespace app\models;

use Yii;
use \app\models\base\SprOut as BaseSprOut;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "spr_out".
 */
class SprOut extends BaseSprOut
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
