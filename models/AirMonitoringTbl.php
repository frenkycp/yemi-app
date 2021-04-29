<?php

namespace app\models;

use Yii;
use \app\models\base\AirMonitoringTbl as BaseAirMonitoringTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.UDARA".
 */
class AirMonitoringTbl extends BaseAirMonitoringTbl
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
