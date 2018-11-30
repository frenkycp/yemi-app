<?php

namespace app\models;

use Yii;
use \app\models\base\WipEffDailyUtilView as BaseWipEffDailyUtilView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_DAILY_UTIL_VIEW".
 */
class WipEffDailyUtilView extends BaseWipEffDailyUtilView
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
