<?php

namespace app\models;

use Yii;
use \app\models\base\ProdAttendanceDailyPlan as BaseProdAttendanceDailyPlan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_ATTENDANCE_DAILY_PLAN".
 */
class ProdAttendanceDailyPlan extends BaseProdAttendanceDailyPlan
{
    public $total_shift1, $total_shift2, $total_shift3;

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
