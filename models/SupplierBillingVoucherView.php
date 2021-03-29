<?php

namespace app\models;

use Yii;
use \app\models\base\SupplierBillingVoucherView as BaseSupplierBillingVoucherView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SUPPLIER_BILLING_VOUCHER_VIEW".
 */
class SupplierBillingVoucherView extends BaseSupplierBillingVoucherView
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
