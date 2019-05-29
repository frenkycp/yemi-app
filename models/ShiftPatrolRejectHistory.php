<?php

namespace app\models;

use Yii;
use \app\models\base\ShiftPatrolRejectHistory as BaseShiftPatrolRejectHistory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIFT_PATROL_REJECT_HISTORY".
 */
class ShiftPatrolRejectHistory extends BaseShiftPatrolRejectHistory
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
