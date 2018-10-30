<?php

namespace app\models;

use Yii;
use \app\models\base\HakAkses as BaseHakAkses;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_hak_akses".
 */
class HakAkses extends BaseHakAkses
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
