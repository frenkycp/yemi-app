<?php

namespace app\models;

use Yii;
use \app\models\base\MesinCheckDtr as BaseMesinCheckDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_CHECK_DTR".
 */
class MesinCheckDtr extends BaseMesinCheckDtr
{

    public $total_data, $total_close, $tgl;

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
