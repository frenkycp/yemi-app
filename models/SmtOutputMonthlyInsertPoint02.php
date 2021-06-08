<?php

namespace app\models;

use Yii;
use \app\models\base\SmtOutputMonthlyInsertPoint02 as BaseSmtOutputMonthlyInsertPoint02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SMT_OUTPUT_MONTHLY_INSERT_POINT_02".
 */
class SmtOutputMonthlyInsertPoint02 extends BaseSmtOutputMonthlyInsertPoint02
{
    public $MOUNTING_RATIO;

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
