<?php

namespace app\models;

use Yii;
use \app\models\base\WeeklyShippingOutView01 as BaseWeeklyShippingOutView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "weekly_shipping_out_view_01".
 */
class WeeklyShippingOutView01 extends BaseWeeklyShippingOutView01
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
