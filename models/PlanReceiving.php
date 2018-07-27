<?php

namespace app\models;

use Yii;
use app\models\base\PlanReceiving as BasePlanReceiving;

/**
 * This is the model class for table "plan_receiving".
 *
 * @property int $id
 * @property string $vendor_name
 * @property string $vehicle
 * @property string $item_type
 * @property int $qty
 * @property string $receiving_date
 * @property string $month_periode
 * @property int $flag
 */
class PlanReceiving extends BasePlanReceiving
{
    public $total_qty, $min_year, $total_container, $total_truck, $total_wb, $week_no;
}
