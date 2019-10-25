<?php

namespace app\models;

use Yii;
use \app\models\base\BeaconTbl as BaseBeaconTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.BEACON_TBL".
 */
class BeaconTbl extends BaseBeaconTbl
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
