<?php

namespace app\models;

use Yii;
use \app\models\base\SernoSlipLog2 as BaseSernoSlipLog2;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_slip_log2".
 */
class SernoSlipLog2 extends BaseSernoSlipLog2
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
