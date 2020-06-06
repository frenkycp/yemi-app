<?php

namespace app\models;

use Yii;
use \app\models\base\FotocopyUserTbl as BaseFotocopyUserTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.FOTOCOPY_USER".
 */
class FotocopyUserTbl extends BaseFotocopyUserTbl
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
