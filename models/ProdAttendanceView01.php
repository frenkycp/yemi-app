<?php

namespace app\models;

use Yii;
use \app\models\base\ProdAttendanceView01 as BaseProdAttendanceView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_ATTENDANCE_VIEW_01".
 */
class ProdAttendanceView01 extends BaseProdAttendanceView01
{
    public $total;

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
