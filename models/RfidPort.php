<?php

namespace app\models;

use Yii;
use \app\models\base\RfidPort as BaseRfidPort;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_rfid_port".
 */
class RfidPort extends BaseRfidPort
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
