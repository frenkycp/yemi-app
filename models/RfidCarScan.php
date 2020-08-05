<?php

namespace app\models;

use Yii;
use \app\models\base\RfidCarScan as BaseRfidCarScan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.RFID_CAR_SCAN".
 */
class RfidCarScan extends BaseRfidCarScan
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
