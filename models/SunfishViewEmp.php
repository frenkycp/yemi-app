<?php

namespace app\models;

use Yii;
use \app\models\base\SunfishViewEmp as BaseSunfishViewEmp;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dbo.VIEW_YEMI_Emp_OrgUnit".
 */
class SunfishViewEmp extends BaseSunfishViewEmp
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
