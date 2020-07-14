<?php

namespace app\models;

use Yii;
use \app\models\base\SapPickingList as BaseSapPickingList;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.sap_picking_list".
 */
class SapPickingList extends BaseSapPickingList
{
    public $total_setlist, $total_open, $total_close;

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
