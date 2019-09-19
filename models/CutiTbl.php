<?php

namespace app\models;

use Yii;
use \app\models\base\CutiTbl as BaseCutiTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.CUTI_TBL".
 */
class CutiTbl extends BaseCutiTbl
{
    public $REMAINING_QTY;

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
