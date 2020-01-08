<?php

namespace app\models;

use Yii;
use \app\models\base\ProdAttendanceMpPlan as BaseProdAttendanceMpPlan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_ATTENDANCE_MP_PLAN".
 */
class ProdAttendanceMpPlan extends BaseProdAttendanceMpPlan
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
