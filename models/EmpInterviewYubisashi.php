<?php

namespace app\models;

use Yii;
use \app\models\base\EmpInterviewYubisashi as BaseEmpInterviewYubisashi;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.EMP_INTERVIEW_YUBISASHI".
 */
class EmpInterviewYubisashi extends BaseEmpInterviewYubisashi
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
