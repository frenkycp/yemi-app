<?php

namespace app\models;

use Yii;
use \app\models\base\SapPoRcv as BaseSapPoRcv;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.sap_po_rcv".
 */
class SapPoRcv extends BaseSapPoRcv
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
