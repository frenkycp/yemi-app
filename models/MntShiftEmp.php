<?php

namespace app\models;

use Yii;
use \app\models\base\MntShiftEmp as BaseMntShiftEmp;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.mnt_shift_emp".
 */
class MntShiftEmp extends BaseMntShiftEmp
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
