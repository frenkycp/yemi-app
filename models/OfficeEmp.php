<?php

namespace app\models;

use Yii;
use \app\models\base\OfficeEmp as BaseOfficeEmp;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.OFFICE_EMP".
 */
class OfficeEmp extends BaseOfficeEmp
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
