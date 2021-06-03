<?php

namespace app\models;

use Yii;
use \app\models\base\SmtAiInsertPoint as BaseSmtAiInsertPoint;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SMT_AI_INSERT_POINT".
 */
class SmtAiInsertPoint extends BaseSmtAiInsertPoint
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
