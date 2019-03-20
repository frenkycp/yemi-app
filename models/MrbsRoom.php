<?php

namespace app\models;

use Yii;
use \app\models\base\MrbsRoom as BaseMrbsRoom;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "mrbs_room".
 */
class MrbsRoom extends BaseMrbsRoom
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
