<?php

namespace app\models;

use Yii;
use \app\models\base\ClinicDailyVisit as BaseClinicDailyVisit;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "clinic_daily_visit".
 */
class ClinicDailyVisit extends BaseClinicDailyVisit
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
