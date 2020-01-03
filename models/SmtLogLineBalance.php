<?php

namespace app\models;

use Yii;
use \app\models\base\SmtLogLineBalance as BaseSmtLogLineBalance;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SMT_PCB_LOG_LINE_BALANCE".
 */
class SmtLogLineBalance extends BaseSmtLogLineBalance
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
