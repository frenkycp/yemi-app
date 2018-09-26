<?php

namespace app\models;

use Yii;
use \app\models\base\GojekTbl as BaseGojekTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GOJEK_TBL".
 */
class GojekTbl extends BaseGojekTbl
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