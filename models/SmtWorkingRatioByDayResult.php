<?php

namespace app\models;

use Yii;
use \app\models\base\SmtWorkingRatioByDayResult as BaseSmtWorkingRatioByDayResult;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SMT_PCB_LOG_WORKING_RATIO_BY_DAY_RESULT".
 */
class SmtWorkingRatioByDayResult extends BaseSmtWorkingRatioByDayResult
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
