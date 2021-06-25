<?php

namespace app\models;

use Yii;
use \app\models\base\SunfishWorkingTimeDaily as BaseSunfishWorkingTimeDaily;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SUNFISH_WORKING_TIME_DAILY".
 */
class SunfishWorkingTimeDaily extends BaseSunfishWorkingTimeDaily
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
