<?php

namespace app\models;

use Yii;
use \app\models\base\SkillMasterLogView as BaseSkillMasterLogView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SKILL_MASTER_LOG_VIEW".
 */
class SkillMasterLogView extends BaseSkillMasterLogView
{
    public $total_training, $total_retraining;

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
