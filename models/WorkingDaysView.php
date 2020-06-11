<?php

namespace app\models;

use Yii;
use \app\models\base\WorkingDaysView as BaseWorkingDaysView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WORKING_DAYS_VIEW".
 */
class WorkingDaysView extends BaseWorkingDaysView
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
