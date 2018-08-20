<?php

namespace app\models;

use Yii;
use \app\models\base\ItrnHisTbl as BaseItrnHisTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ITRN_HIS_TBL".
 */
class ItrnHisTbl extends BaseItrnHisTbl
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
