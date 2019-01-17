<?php

namespace app\models;

use Yii;
use \app\models\base\WipEff03 as BaseWipEff03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_03".
 */
class WipEff03 extends BaseWipEff03
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
