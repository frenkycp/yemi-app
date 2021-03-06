<?php

namespace app\models;

use Yii;
use \app\models\base\SernoSlipLog as BaseSernoSlipLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_slip_log".
 */
class SernoSlipLog extends BaseSernoSlipLog
{
    public $order_date, $period, $total_count, $total_open, $total_close, $start_time, $end_time, $total_working, $avg_completion;

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
