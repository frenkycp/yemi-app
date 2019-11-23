<?php

namespace app\models;

use Yii;
use \app\models\base\KanbanPchLog as BaseKanbanPchLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.KANBAN_PCH_LOG".
 */
class KanbanPchLog extends BaseKanbanPchLog
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
