<?php

namespace app\models;

use Yii;
use \app\models\base\WipHdrDtr as BaseWipHdrDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_HDR_DTR".
 */
class WipHdrDtr extends BaseWipHdrDtr
{
    public $summary_qty, $complete_qty, $plan_total, $output_total, $balance_total, $total_order, $total_started, $total_completed;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['summary_qty', 'complete_qty'], 'number']
            ]
        );
    }
}
