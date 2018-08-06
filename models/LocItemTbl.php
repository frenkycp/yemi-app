<?php

namespace app\models;

use Yii;
use \app\models\base\LocItemTbl as BaseLocItemTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.LOC_ITEM_TBL".
 */
class LocItemTbl extends BaseLocItemTbl
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
