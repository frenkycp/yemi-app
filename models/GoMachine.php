<?php

namespace app\models;

use Yii;
use \app\models\base\GoMachine as BaseGoMachine;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GO_MACHINE".
 */
class GoMachine extends BaseGoMachine
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
