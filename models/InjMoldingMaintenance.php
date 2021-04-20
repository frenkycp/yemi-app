<?php

namespace app\models;

use Yii;
use \app\models\base\InjMoldingMaintenance as BaseInjMoldingMaintenance;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.INJ_MOLDING_MAINTENANCE".
 */
class InjMoldingMaintenance extends BaseInjMoldingMaintenance
{
    public $TOTAL_TIME_VIEW;

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
