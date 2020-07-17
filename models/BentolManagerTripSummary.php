<?php

namespace app\models;

use Yii;
use \app\models\base\BentolManagerTripSummary as BaseBentolManagerTripSummary;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_manager_trip_summary".
 */
class BentolManagerTripSummary extends BaseBentolManagerTripSummary
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
