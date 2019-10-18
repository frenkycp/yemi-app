<?php

namespace app\models;

use Yii;
use \app\models\base\WwStockWaitingProcess02Open as BaseWwStockWaitingProcess02Open;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WW_STOCK_WAITING_PROCESS_02_OPEN".
 */
class WwStockWaitingProcess02Open extends BaseWwStockWaitingProcess02Open
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
