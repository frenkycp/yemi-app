<?php

namespace app\models;

use Yii;
use \app\models\base\WwStockWaitingProcess01 as BaseWwStockWaitingProcess01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WW_STOCK_WAITING_PROCESS_01".
 */
class WwStockWaitingProcess01 extends BaseWwStockWaitingProcess01
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
