<?php

namespace app\models;

use Yii;
use \app\models\base\SalesBudgetDtrTbl as BaseSalesBudgetDtrTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SALES_BUDGET_DTR_TBL".
 */
class SalesBudgetDtrTbl extends BaseSalesBudgetDtrTbl
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
