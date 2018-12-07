<?php

namespace app\models;

use Yii;
use \app\models\base\WipEffDailyUtilView03 as BaseWipEffDailyUtilView03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_DAILY_UTIL_VIEW_03".
 */
class WipEffDailyUtilView03 extends BaseWipEffDailyUtilView03
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
