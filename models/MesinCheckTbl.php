<?php

namespace app\models;

use Yii;
use \app\models\base\MesinCheckTbl as BaseMesinCheckTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_CHECK_TBL".
 */
class MesinCheckTbl extends BaseMesinCheckTbl
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
