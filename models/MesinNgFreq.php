<?php

namespace app\models;

use Yii;
use \app\models\base\MesinNgFreq as BaseMesinNgFreq;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_NG_FREQ".
 */
class MesinNgFreq extends BaseMesinNgFreq
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
