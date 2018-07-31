<?php

namespace app\models;

use Yii;
use \app\models\base\MntShiftCode as BaseMntShiftCode;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.mnt_shift_code".
 */
class MntShiftCode extends BaseMntShiftCode
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
