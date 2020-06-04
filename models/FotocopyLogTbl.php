<?php

namespace app\models;

use Yii;
use \app\models\base\FotocopyLogTbl as BaseFotocopyLogTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.FOTOCOPY_LOG".
 */
class FotocopyLogTbl extends BaseFotocopyLogTbl
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
