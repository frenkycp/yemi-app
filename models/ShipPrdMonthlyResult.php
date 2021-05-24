<?php

namespace app\models;

use Yii;
use \app\models\base\ShipPrdMonthlyResult as BaseShipPrdMonthlyResult;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIP_PRD_MONTHLY_RESULT".
 */
class ShipPrdMonthlyResult extends BaseShipPrdMonthlyResult
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
