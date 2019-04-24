<?php

namespace app\models;

use Yii;
use \app\models\base\ClinicMonthlyVisit01 as BaseClinicMonthlyVisit01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "clinic_monthly_visit_01".
 */
class ClinicMonthlyVisit01 extends BaseClinicMonthlyVisit01
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
