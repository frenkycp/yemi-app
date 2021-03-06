<?php

namespace app\models;

use Yii;
use \app\models\base\KanbanFlowDtr as BaseKanbanFlowDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.KANBAN_FLOW_DTR".
 */
class KanbanFlowDtr extends BaseKanbanFlowDtr
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
