<?php

namespace app\models;

use Yii;
use \app\models\base\SkillMaster as BaseSkillMaster;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SKILL_MASTER".
 */
class SkillMaster extends BaseSkillMaster
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
