<?php

namespace app\models;

use Yii;
use \app\models\base\BentolManagerTrip as BaseBentolManagerTrip;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_manager_trip".
 */
class BentolManagerTrip extends BaseBentolManagerTrip
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
