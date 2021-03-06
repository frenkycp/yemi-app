<?php

namespace app\models;

use Yii;
use \app\models\base\AuditPatrolPic as BaseAuditPatrolPic;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.AUDIT_PATROL_PIC".
 */
class AuditPatrolPic extends BaseAuditPatrolPic
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
