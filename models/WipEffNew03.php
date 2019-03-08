<?php

namespace app\models;

use Yii;
use \app\models\base\WipEffNew03 as BaseWipEffNew03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_NEW_03".
 */
class WipEffNew03 extends BaseWipEffNew03
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
