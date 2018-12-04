<?php

namespace app\models;

use Yii;
use \app\models\base\RfidGate as BaseRfidGate;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_rfid_gate".
 */
class RfidGate extends BaseRfidGate
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
