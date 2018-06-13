<?php

namespace app\models;

use Yii;
use \app\models\base\MesinNgFreq04 as BaseMesinNgFreq04;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_NG_FREQ_04".
 */
class MesinNgFreq04 extends BaseMesinNgFreq04
{
    public $total_freq, $total_lama_perbaikan;

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
