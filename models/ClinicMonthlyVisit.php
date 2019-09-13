<?php

namespace app\models;

use Yii;
use \app\models\base\ClinicMonthlyVisit as BaseClinicMonthlyVisit;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "clinic_monthly_visit".
 */
class ClinicMonthlyVisit extends BaseClinicMonthlyVisit
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
