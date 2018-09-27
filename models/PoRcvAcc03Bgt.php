<?php

namespace app\models;

use Yii;
use \app\models\base\PoRcvAcc03Bgt as BasePoRcvAcc03Bgt;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PO_RCV_ACC_03_BGT".
 */
class PoRcvAcc03Bgt extends BasePoRcvAcc03Bgt
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
