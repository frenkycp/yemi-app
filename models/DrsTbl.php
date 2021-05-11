<?php

namespace app\models;

use Yii;
use \app\models\base\DrsTbl as BaseDrsTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.DRS_TBL".
 */
class DrsTbl extends BaseDrsTbl
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
