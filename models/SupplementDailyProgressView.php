<?php

namespace app\models;

use Yii;
use \app\models\base\SupplementDailyProgressView as BaseSupplementDailyProgressView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "supllement_daily_progress_view".
 */
class SupplementDailyProgressView extends BaseSupplementDailyProgressView
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
