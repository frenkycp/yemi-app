<?php

namespace app\models;

use Yii;
use \app\models\base\SapPickingListPtsView as BaseSapPickingListPtsView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.sap_picking_list_pts_old_cur_view".
 */
class SapPickingListPtsView extends BaseSapPickingListPtsView
{
    public $total_count;

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
