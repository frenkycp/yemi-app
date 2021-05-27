<?php

namespace app\models;

use Yii;
use \app\models\base\ShipPrdDelayInformation as BaseShipPrdDelayInformation;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIP_PRD_DELAY_INFORMATION".
 */
class ShipPrdDelayInformation extends BaseShipPrdDelayInformation
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
