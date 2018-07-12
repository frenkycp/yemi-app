<?php

namespace app\models;

use Yii;
use \app\models\base\MesinCheckNgDtr as BaseMesinCheckNgDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_CHECK_NG_DTR".
 */
class MesinCheckNgDtr extends BaseMesinCheckNgDtr
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
