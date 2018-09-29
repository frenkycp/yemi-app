<?php

namespace app\models;

use Yii;
use \app\models\base\SernoMp as BaseSernoMp;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_mp".
 */
class SernoMp extends BaseSernoMp
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
