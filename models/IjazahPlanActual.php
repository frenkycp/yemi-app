<?php

namespace app\models;

use Yii;
use \app\models\base\IjazahPlanActual as BaseIjazahPlanActual;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.IJAZAH_PLAN_ACTUAL".
 */
class IjazahPlanActual extends BaseIjazahPlanActual
{
    public $amt_ratio, $qty_ratio;

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
