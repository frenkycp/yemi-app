<?php

namespace app\models;

use Yii;
use \app\models\base\SupplierBillingVoucher as BaseSupplierBillingVoucher;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SUPPLIER_BILLING_VOUCHER".
 */
class SupplierBillingVoucher extends BaseSupplierBillingVoucher
{
    public $invoice_no, $base64_txt, $attachment_file;

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
                [['attachment_file'], 'file', 'extensions' => ['pdf'], 'skipOnEmpty' => false],
                [['invoice_no'], 'required'],
            ]
        );
    }
}
