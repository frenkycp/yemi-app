<?php

namespace app\models;

use Yii;
use \app\models\base\CutiRekapView02 as BaseCutiRekapView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.CUTI_REKAP_VIEW_02".
 */
class CutiRekapView02 extends BaseCutiRekapView02
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
