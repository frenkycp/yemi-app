<?php

namespace app\models;

use Yii;
use \app\models\base\WipEffNew12 as BaseWipEffNew12;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_NEW_12".
 */
class WipEffNew12 extends BaseWipEffNew12
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
