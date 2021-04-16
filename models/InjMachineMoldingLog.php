<?php

namespace app\models;

use Yii;
use \app\models\base\InjMachineMoldingLog as BaseInjMachineMoldingLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.INJ_MACHINE_MOLDING_LOG".
 */
class InjMachineMoldingLog extends BaseInjMachineMoldingLog
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
