<?php

namespace app\models;

use Yii;
use \app\models\base\VisualPickingList as BaseVisualPickingList;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.visual_picking_list".
 */
class VisualPickingList extends BaseVisualPickingList
{
    public $manpower_desc;

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

    public function getGojekOrderTbl()
    {
        return $this->hasOne(GojekOrderTbl::className(), ['slip_id' => 'set_list_no']);
    }
}
