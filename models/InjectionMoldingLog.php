<?php

namespace app\models;

use Yii;
use \app\models\base\InjectionMoldingLog as BaseInjectionMoldingLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.INJECTION_MOLDING_LOG".
 */
class InjectionMoldingLog extends BaseInjectionMoldingLog
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
