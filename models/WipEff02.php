<?php

namespace app\models;

use Yii;
use \app\models\base\WipEff02 as BaseWipEff02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_02".
 */
class WipEff02 extends BaseWipEff02
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
