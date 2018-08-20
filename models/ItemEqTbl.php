<?php

namespace app\models;

use Yii;
use \app\models\base\ItemEqTbl as BaseItemEqTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ITEM_EQ_TBL".
 */
class ItemEqTbl extends BaseItemEqTbl
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
