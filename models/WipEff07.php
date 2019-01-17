<?php

namespace app\models;

use Yii;
use \app\models\base\WipEff07 as BaseWipEff07;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_07".
 */
class WipEff07 extends BaseWipEff07
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
