<?php

namespace app\models;

use Yii;
use \app\models\base\RunningHoursView01 as BaseRunningHoursView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.RUNNING_HOURS_VIEW_01".
 */
class RunningHoursView01 extends BaseRunningHoursView01
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
