<?php

namespace app\models;

use Yii;
use \app\models\base\AirCompressorDailyView as BaseAirCompressorDailyView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.AIR_COMPRESSOR_DAILY_VIEW".
 */
class AirCompressorDailyView extends BaseAirCompressorDailyView
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
