<?php

namespace app\models;

use Yii;
use \app\models\base\SalesBudgetCompare as BaseSalesBudgetCompare;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SALES_BUDGET_COMPARE".
 */
class SalesBudgetCompare extends BaseSalesBudgetCompare
{
    public $total_qty_actual, $total_amount_actual, $total_qty_budget, $total_amount_budget, $total_qty_forecast, $total_amount_forecast, $balance_qty, $balance_amount;

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
