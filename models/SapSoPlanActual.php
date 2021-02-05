<?php

namespace app\models;

use Yii;
use \app\models\base\SapSoPlanActual as BaseSapSoPlanActual;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SAP_SO_PLAN_ACTUAL".
 */
class SapSoPlanActual extends BaseSapSoPlanActual
{
    public $total_otd, $total_early, $total_outstanding, $total_late;

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
