<?php

namespace app\models;

use Yii;
use \app\models\base\MinimumStockView02 as BaseMinimumStockView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MINIMUM_STOCK_VIEW_02".
 */
class MinimumStockView02 extends BaseMinimumStockView02
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
