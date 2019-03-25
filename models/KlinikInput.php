<?php

namespace app\models;

use Yii;
use \app\models\base\KlinikInput as BaseKlinikInput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_klinik_input".
 */
class KlinikInput extends BaseKlinikInput
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
