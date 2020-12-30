<?php

namespace app\models;

use Yii;
use \app\models\base\SmtAiOutputInsertPoint01 as BaseSmtAiOutputInsertPoint01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SMT_AI_OUTPUT_INSERT_POINT_01".
 */
class SmtAiOutputInsertPoint01 extends BaseSmtAiOutputInsertPoint01
{
    public $TOTAL_INSERT_POINT, $TOTAL_JV, $TOTAL_AX, $TOTAL_RH;

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
