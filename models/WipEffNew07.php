<?php

namespace app\models;

use Yii;
use \app\models\base\WipEffNew07 as BaseWipEffNew07;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_NEW_07".
 */
class WipEffNew07 extends BaseWipEffNew07
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
