<?php

namespace app\models;

use Yii;
use \app\models\base\SernoCalendar as BaseSernoCalendar;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_calendar".
 */
class SernoCalendar extends BaseSernoCalendar
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
