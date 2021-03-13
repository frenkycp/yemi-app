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
    public $upload_before_1, $upload_before_2, $upload_before_3, $upload_after_1, $upload_after_2, $upload_after_3, $total_open, $total_close, $total_5s, $total_safety, $PATROL_PRESIDR_OPEN, $PATROL_PRESIDR_CLOSE, $PATROL_GM_OPEN, $PATROL_GM_CLOSE;

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
