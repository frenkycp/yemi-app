<?php

namespace app\models;

use Yii;
use \app\models\base\SapPickingPtsDetailView as BaseSapPickingPtsDetailView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.sap_picking_pts_old_cur".
 */
class SapPickingPtsDetailView extends BaseSapPickingPtsDetailView
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
