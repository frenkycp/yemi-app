<?php

namespace app\models;

use Yii;
use \app\models\base\SmtLogLineBalanceReport as BaseSmtLogLineBalanceReport;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SMT_PCB_LOG_LINE_BALANCE_REPORT".
 */
class SmtLogLineBalanceReport extends BaseSmtLogLineBalanceReport
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
