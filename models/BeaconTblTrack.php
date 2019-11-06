<?php

namespace app\models;

use Yii;
use \app\models\base\BeaconTblTrack as BaseBeaconTblTrack;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.BEACON_TBL_TRACK".
 */
class BeaconTblTrack extends BaseBeaconTblTrack
{
    public $total_qty;

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
