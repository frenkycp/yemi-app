<?php

namespace app\models;

use Yii;
use \app\models\base\DataMonitoringFa as BaseDataMonitoringFa;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.DATA_MONITORING_FA".
 */
class DataMonitoringFa extends BaseDataMonitoringFa
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
