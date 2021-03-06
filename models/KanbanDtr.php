<?php

namespace app\models;

use Yii;
use \app\models\base\KanbanDtr as BaseKanbanDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.KANBAN_DTR".
 */
class KanbanDtr extends BaseKanbanDtr
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                'job_dtr_close_reason' => 'Reason',
            ]
        );
    }
}
