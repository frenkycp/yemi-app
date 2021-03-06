<?php

namespace app\models;

use Yii;
use \app\models\base\MrbsEntry as BaseMrbsEntry;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "mrbs_entry".
 */
class MrbsEntry extends BaseMrbsEntry
{
    public $tgl_start, $tgl_end, $pic_id, $pic_name, $total_member, $started_by, $room_name;

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
