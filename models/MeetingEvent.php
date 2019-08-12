<?php

namespace app\models;

use Yii;
use \app\models\base\MeetingEvent as BaseMeetingEvent;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "meeting_event".
 */
class MeetingEvent extends BaseMeetingEvent
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
