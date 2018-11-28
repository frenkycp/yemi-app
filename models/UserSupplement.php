<?php

namespace app\models;

use Yii;
use \app\models\base\UserSupplement as BaseUserSupplement;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 */
class UserSupplement extends BaseUserSupplement
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
