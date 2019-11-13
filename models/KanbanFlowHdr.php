<?php

namespace app\models;

use Yii;
use \app\models\base\KanbanFlowHdr as BaseKanbanFlowHdr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.KANBAN_FLOW_HDR".
 */
class KanbanFlowHdr extends BaseKanbanFlowHdr
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
