<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SapPoRcvSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="sap-po-rcv-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'seq_id') ?>

		<?= $form->field($model, 'local_import') ?>

		<?= $form->field($model, 'currency') ?>

		<?= $form->field($model, 'rate') ?>

		<?= $form->field($model, 'abc_indicator') ?>

		<?php // echo $form->field($model, 'vendor_code') ?>

		<?php // echo $form->field($model, 'vendor_name') ?>

		<?php // echo $form->field($model, 'payment_terms') ?>

		<?php // echo $form->field($model, 'freight_cond_type') ?>

		<?php // echo $form->field($model, 'freight') ?>

		<?php // echo $form->field($model, 'insurance_cond_type') ?>

		<?php // echo $form->field($model, 'insurance') ?>

		<?php // echo $form->field($model, 'internal_exp_cond_type') ?>

		<?php // echo $form->field($model, 'internal_exp') ?>

		<?php // echo $form->field($model, 'no') ?>

		<?php // echo $form->field($model, 'rcv_date') ?>

		<?php // echo $form->field($model, 'material_document_number') ?>

		<?php // echo $form->field($model, 'item_no') ?>

		<?php // echo $form->field($model, 'inv_no') ?>

		<?php // echo $form->field($model, 'po_id') ?>

		<?php // echo $form->field($model, 'slip_no') ?>

		<?php // echo $form->field($model, 'acct_assig_cat') ?>

		<?php // echo $form->field($model, 'material') ?>

		<?php // echo $form->field($model, 'description') ?>

		<?php // echo $form->field($model, 'quantity') ?>

		<?php // echo $form->field($model, 'um') ?>

		<?php // echo $form->field($model, 'quantity_pur_unit') ?>

		<?php // echo $form->field($model, 'pur_um') ?>

		<?php // echo $form->field($model, 'unit_price') ?>

		<?php // echo $form->field($model, 'amount_rcv') ?>

		<?php // echo $form->field($model, 'amount_ppn') ?>

		<?php // echo $form->field($model, 'amount_wh') ?>

		<?php // echo $form->field($model, 'amount_usd') ?>

		<?php // echo $form->field($model, 'amount_freight') ?>

		<?php // echo $form->field($model, 'amount_insurance') ?>

		<?php // echo $form->field($model, 'amount_internal_exp') ?>

		<?php // echo $form->field($model, 'amount_total_charges') ?>

		<?php // echo $form->field($model, 'amount_total') ?>

		<?php // echo $form->field($model, 'direct_indirect') ?>

		<?php // echo $form->field($model, 'std_price') ?>

		<?php // echo $form->field($model, 'std_amount') ?>

		<?php // echo $form->field($model, 'nat_acc') ?>

		<?php // echo $form->field($model, 'nat_acc_desc') ?>

		<?php // echo $form->field($model, 'cost_center') ?>

		<?php // echo $form->field($model, 'cost_center_desc') ?>

		<?php // echo $form->field($model, 'purchasing_group') ?>

		<?php // echo $form->field($model, 'vendor_country_code') ?>

		<?php // echo $form->field($model, 'order_date') ?>

		<?php // echo $form->field($model, 'order_quantity') ?>

		<?php // echo $form->field($model, 'order_delivery_date') ?>

		<?php // echo $form->field($model, 'relied_delivery_date') ?>

		<?php // echo $form->field($model, 'relied_delivery_qty') ?>

		<?php // echo $form->field($model, 'storage_location_po') ?>

		<?php // echo $form->field($model, 'movement_type') ?>

		<?php // echo $form->field($model, 'lt_po') ?>

		<?php // echo $form->field($model, 'grt_po') ?>

		<?php // echo $form->field($model, 'stock_type_po') ?>

		<?php // echo $form->field($model, 'delivery_completed') ?>

		<?php // echo $form->field($model, 'cust_doc_date') ?>

		<?php // echo $form->field($model, 'doc_type') ?>

		<?php // echo $form->field($model, 'cust_doc_no') ?>

		<?php // echo $form->field($model, 'po_no') ?>

		<?php // echo $form->field($model, 'po_line') ?>

		<?php // echo $form->field($model, 'upload') ?>

		<?php // echo $form->field($model, 'period') ?>

		<?php // echo $form->field($model, 'fix_add') ?>

		<?php // echo $form->field($model, 'voucher_no') ?>

		<?php // echo $form->field($model, 'invoice_act') ?>

		<?php // echo $form->field($model, 'kwitansi_act') ?>

		<?php // echo $form->field($model, 'price_act') ?>

		<?php // echo $form->field($model, 'amount_act') ?>

		<?php // echo $form->field($model, 'variance_act') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'bc_type') ?>

		<?php // echo $form->field($model, 'bc_no') ?>

		<?php // echo $form->field($model, 'bc_date') ?>

		<?php // echo $form->field($model, 'sign') ?>

		<?php // echo $form->field($model, 'upload_date') ?>

		<?php // echo $form->field($model, 'asano_doc') ?>

		<?php // echo $form->field($model, 'asano_invoice') ?>

		<?php // echo $form->field($model, 'pic') ?>

		<?php // echo $form->field($model, 'division') ?>

		<?php // echo $form->field($model, 'sinkron') ?>

		<?php // echo $form->field($model, 'Inspection_level') ?>

		<?php // echo $form->field($model, 'Judgement') ?>

		<?php // echo $form->field($model, 'Remark') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
