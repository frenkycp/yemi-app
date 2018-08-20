<?php

namespace app\models;

use Yii;
use \app\models\base\CalendarView as BaseCalendarView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "calendar_view".
 */
class CalendarView extends BaseCalendarView
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
