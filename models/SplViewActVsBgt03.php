<?php

namespace app\models;

use Yii;
use \app\models\base\SplViewActVsBgt03 as BaseSplViewActVsBgt03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SPL_VIEW_ACT_VS_BGT_03".
 */
class SplViewActVsBgt03 extends BaseSplViewActVsBgt03
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
