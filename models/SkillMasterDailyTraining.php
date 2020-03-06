<?php

namespace app\models;

use Yii;
use \app\models\base\SkillMasterDailyTraining as BaseSkillMasterDailyTraining;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SKILL_MASTER_DAILY_TRAINING".
 */
class SkillMasterDailyTraining extends BaseSkillMasterDailyTraining
{
    public $total;

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
