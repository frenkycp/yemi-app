<?php

namespace app\models;

use Yii;
use \app\models\base\KanbanHdr as BaseKanbanHdr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.KANBAN_HDR".
 */
class KanbanHdr extends BaseKanbanHdr
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
                'job_desc' => 'Job Description',
                'job_hdr_no' => 'Job No.',
                'job_flow_id' => 'Job Group',
                'request_to_nik' => 'Request to'
            ]
        );
    }
}
