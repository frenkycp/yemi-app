<?php

namespace app\models;

use Yii;
use \app\models\base\FotocopyTbl as BaseFotocopyTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.FOTOCOPY".
 */
class FotocopyTbl extends BaseFotocopyTbl
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
