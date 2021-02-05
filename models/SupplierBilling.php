<?php

namespace app\models;

use Yii;
use \app\models\base\SupplierBilling as BaseSupplierBilling;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SUPPLIER_BILLING".
 */
class SupplierBilling extends BaseSupplierBilling
{
    public $total_stage1, $total_stage2, $total_stage3;

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
