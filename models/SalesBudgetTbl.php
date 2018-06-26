<?php

namespace app\models;

use Yii;
use \app\models\base\SalesBudgetTbl as BaseSalesBudgetTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SALES_BUDGET_TBL".
 */
class SalesBudgetTbl extends BaseSalesBudgetTbl
{
    public $qty_or_amount, $budget_type;

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
