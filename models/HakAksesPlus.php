<?php

namespace app\models;

use Yii;
use \app\models\base\HakAksesPlus as BaseHakAksesPlus;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_hak_akses_plus".
 */
class HakAksesPlus extends BaseHakAksesPlus
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
