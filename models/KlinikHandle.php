<?php

namespace app\models;

use Yii;
use \app\models\base\KlinikHandle as BaseKlinikHandle;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_klinik_handle".
 */
class KlinikHandle extends BaseKlinikHandle
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
