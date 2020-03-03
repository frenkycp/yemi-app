<?php

namespace app\models;

use Yii;
use \app\models\base\SkillMasterKaryawanLog as BaseSkillMasterKaryawanLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SKILL_MASTER_KARYAWAN_LOG".
 */
class SkillMasterKaryawanLog extends BaseSkillMasterKaryawanLog
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
