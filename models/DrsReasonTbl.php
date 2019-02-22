<?php

namespace app\models;

use Yii;
use \app\models\base\DrsReasonTbl as BaseDrsReasonTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.DRS_REASON_TBL".
 */
class DrsReasonTbl extends BaseDrsReasonTbl
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
