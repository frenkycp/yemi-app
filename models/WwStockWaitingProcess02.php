<?php

namespace app\models;

use Yii;
use \app\models\base\WwStockWaitingProcess02 as BaseWwStockWaitingProcess02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WW_STOCK_WAITING_PROCESS_02".
 */
class WwStockWaitingProcess02 extends BaseWwStockWaitingProcess02
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
