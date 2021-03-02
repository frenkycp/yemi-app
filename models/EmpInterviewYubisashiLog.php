<?php

namespace app\models;

use Yii;
use \app\models\base\EmpInterviewYubisashiLog as BaseEmpInterviewYubisashiLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.EMP_INTERVIEW_YUBISASHI_LOG".
 */
class EmpInterviewYubisashiLog extends BaseEmpInterviewYubisashiLog
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
