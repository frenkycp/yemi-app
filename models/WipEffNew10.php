<?php

namespace app\models;

use Yii;
use \app\models\base\WipEffNew10 as BaseWipEffNew10;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_NEW_10".
 */
class WipEffNew10 extends BaseWipEffNew10
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
