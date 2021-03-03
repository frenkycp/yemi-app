<?php

namespace app\models;

use Yii;
use \app\models\base\AuditPatrolTbl as BaseAuditPatrolTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.AUDIT_PATROL_TBL".
 */
class AuditPatrolTbl extends BaseAuditPatrolTbl
{
    public $upload_before_1, $upload_before_2, $upload_before_3, $upload_after_1, $upload_after_2, $upload_after_3;

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
                [['upload_before_1', 'upload_before_2', 'upload_before_3', 'upload_after_1', 'upload_after_2', 'upload_after_3'], 'file']
            ]
        );
    }
}
