<?php

namespace app\models;

use Yii;
use \app\models\base\InjMouldingTbl as BaseInjMouldingTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.INJ_MOULDING_TBL".
 */
class InjMouldingTbl extends BaseInjMouldingTbl
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
