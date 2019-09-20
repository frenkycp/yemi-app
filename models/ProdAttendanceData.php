<?php

namespace app\models;

use Yii;
use \app\models\base\ProdAttendanceData as BaseProdAttendanceData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_ATTENDANCE_DATA".
 */
class ProdAttendanceData extends BaseProdAttendanceData
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
