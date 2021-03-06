<?php

namespace app\models;

use Yii;
use \app\models\base\HrLoginLog as BaseHrLoginLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.HR_LOGIN_LOG".
 */
class HrLoginLog extends BaseHrLoginLog
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
