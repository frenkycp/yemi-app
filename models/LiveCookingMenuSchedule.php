<?php

namespace app\models;

use Yii;
use \app\models\base\LiveCookingMenuSchedule as BaseLiveCookingMenuSchedule;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.LIVE_COOKING_MENU_SCHEDULE".
 */
class LiveCookingMenuSchedule extends BaseLiveCookingMenuSchedule
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
