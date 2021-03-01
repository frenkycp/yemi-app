<?php

namespace app\models;

use Yii;
use \app\models\base\SapSoPrice as BaseSapSoPrice;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SAP_SO_PRICE".
 */
class SapSoPrice extends BaseSapSoPrice
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
