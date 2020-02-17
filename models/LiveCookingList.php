<?php

namespace app\models;

use Yii;
use \app\models\base\LiveCookingList as BaseLiveCookingList;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.LIVE_COOKING_LIST".
 */
class LiveCookingList extends BaseLiveCookingList
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
