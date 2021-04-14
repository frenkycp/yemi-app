<?php

namespace app\models;

use Yii;
use \app\models\base\InjMachineTbl as BaseInjMachineTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.INJ_MACHINE_TBL".
 */
class InjMachineTbl extends BaseInjMachineTbl
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
