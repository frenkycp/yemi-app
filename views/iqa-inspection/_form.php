<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\SapPoRcv $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="sap-po-rcv-form">

    <?php $form = ActiveForm::begin([
    'id' => 'SapPoRcv',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute local_import -->
			<?= $form->field($model, 'local_import')->textInput() ?>

<!-- attribute currency -->
			<?= $form->field($model, 'currency')->textInput() ?>

<!-- attribute abc_indicator -->
			<?= $form->field($model, 'abc_indicator')->textInput() ?>

<!-- attribute vendor_code -->
			<?= $form->field($model, 'vendor_code')->textInput() ?>

<!-- attribute vendor_name -->
			<?= $form->field($model, 'vendor_name')->textInput() ?>

<!-- attribute payment_terms -->
			<?= $form->field($model, 'payment_terms')->textInput() ?>

<!-- attribute freight_cond_type -->
			<?= $form->field($model, 'freight_cond_type')->textInput() ?>

<!-- attribute insurance_cond_type -->
			<?= $form->field($model, 'insurance_cond_type')->textInput() ?>

<!-- attribute internal_exp_cond_type -->
			<?= $form->field($model, 'internal_exp_cond_type')->textInput() ?>

<!-- attribute no -->
			<?= $form->field($model, 'no')->textInput() ?>

<!-- attribute material_document_number -->
			<?= $form->field($model, 'material_document_number')->textInput() ?>

<!-- attribute item_no -->
			<?= $form->field($model, 'item_no')->textInput() ?>

<!-- attribute inv_no -->
			<?= $form->field($model, 'inv_no')->textInput() ?>

<!-- attribute po_id -->
			<?= $form->field($model, 'po_id')->textInput() ?>

<!-- attribute slip_no -->
			<?= $form->field($model, 'slip_no')->textInput() ?>

<!-- attribute acct_assig_cat -->
			<?= $form->field($model, 'acct_assig_cat')->textInput() ?>

<!-- attribute material -->
			<?= $form->field($model, 'material')->textInput() ?>

<!-- attribute description -->
			<?= $form->field($model, 'description')->textInput() ?>

<!-- attribute um -->
			<?= $form->field($model, 'um')->textInput() ?>

<!-- attribute pur_um -->
			<?= $form->field($model, 'pur_um')->textInput() ?>

<!-- attribute direct_indirect -->
			<?= $form->field($model, 'direct_indirect')->textInput() ?>

<!-- attribute nat_acc -->
			<?= $form->field($model, 'nat_acc')->textInput() ?>

<!-- attribute nat_acc_desc -->
			<?= $form->field($model, 'nat_acc_desc')->textInput() ?>

<!-- attribute cost_center -->
			<?= $form->field($model, 'cost_center')->textInput() ?>

<!-- attribute cost_center_desc -->
			<?= $form->field($model, 'cost_center_desc')->textInput() ?>

<!-- attribute purchasing_group -->
			<?= $form->field($model, 'purchasing_group')->textInput() ?>

<!-- attribute vendor_country_code -->
			<?= $form->field($model, 'vendor_country_code')->textInput() ?>

<!-- attribute storage_location_po -->
			<?= $form->field($model, 'storage_location_po')->textInput() ?>

<!-- attribute movement_type -->
			<?= $form->field($model, 'movement_type')->textInput() ?>

<!-- attribute lt_po -->
			<?= $form->field($model, 'lt_po')->textInput() ?>

<!-- attribute grt_po -->
			<?= $form->field($model, 'grt_po')->textInput() ?>

<!-- attribute stock_type_po -->
			<?= $form->field($model, 'stock_type_po')->textInput() ?>

<!-- attribute delivery_completed -->
			<?= $form->field($model, 'delivery_completed')->textInput() ?>

<!-- attribute cust_doc_date -->
			<?= $form->field($model, 'cust_doc_date')->textInput() ?>

<!-- attribute doc_type -->
			<?= $form->field($model, 'doc_type')->textInput() ?>

<!-- attribute cust_doc_no -->
			<?= $form->field($model, 'cust_doc_no')->textInput() ?>

<!-- attribute po_no -->
			<?= $form->field($model, 'po_no')->textInput() ?>

<!-- attribute po_line -->
			<?= $form->field($model, 'po_line')->textInput() ?>

<!-- attribute upload -->
			<?= $form->field($model, 'upload')->textInput() ?>

<!-- attribute period -->
			<?= $form->field($model, 'period')->textInput() ?>

<!-- attribute fix_add -->
			<?= $form->field($model, 'fix_add')->textInput() ?>

<!-- attribute voucher_no -->
			<?= $form->field($model, 'voucher_no')->textInput() ?>

<!-- attribute invoice_act -->
			<?= $form->field($model, 'invoice_act')->textInput() ?>

<!-- attribute kwitansi_act -->
			<?= $form->field($model, 'kwitansi_act')->textInput() ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

<!-- attribute bc_type -->
			<?= $form->field($model, 'bc_type')->textInput() ?>

<!-- attribute bc_no -->
			<?= $form->field($model, 'bc_no')->textInput() ?>

<!-- attribute sign -->
			<?= $form->field($model, 'sign')->textInput() ?>

<!-- attribute asano_doc -->
			<?= $form->field($model, 'asano_doc')->textInput() ?>

<!-- attribute asano_invoice -->
			<?= $form->field($model, 'asano_invoice')->textInput() ?>

<!-- attribute pic -->
			<?= $form->field($model, 'pic')->textInput() ?>

<!-- attribute division -->
			<?= $form->field($model, 'division')->textInput() ?>

<!-- attribute sinkron -->
			<?= $form->field($model, 'sinkron')->textInput() ?>

<!-- attribute Inspection_level -->
			<?= $form->field($model, 'Inspection_level')->textInput() ?>

<!-- attribute Judgement -->
			<?= $form->field($model, 'Judgement')->textInput() ?>

<!-- attribute Remark -->
			<?= $form->field($model, 'Remark')->textInput() ?>

<!-- attribute rate -->
			<?= $form->field($model, 'rate')->textInput() ?>

<!-- attribute freight -->
			<?= $form->field($model, 'freight')->textInput() ?>

<!-- attribute insurance -->
			<?= $form->field($model, 'insurance')->textInput() ?>

<!-- attribute internal_exp -->
			<?= $form->field($model, 'internal_exp')->textInput() ?>

<!-- attribute quantity -->
			<?= $form->field($model, 'quantity')->textInput() ?>

<!-- attribute quantity_pur_unit -->
			<?= $form->field($model, 'quantity_pur_unit')->textInput() ?>

<!-- attribute unit_price -->
			<?= $form->field($model, 'unit_price')->textInput() ?>

<!-- attribute amount_rcv -->
			<?= $form->field($model, 'amount_rcv')->textInput() ?>

<!-- attribute amount_ppn -->
			<?= $form->field($model, 'amount_ppn')->textInput() ?>

<!-- attribute amount_wh -->
			<?= $form->field($model, 'amount_wh')->textInput() ?>

<!-- attribute amount_usd -->
			<?= $form->field($model, 'amount_usd')->textInput() ?>

<!-- attribute amount_freight -->
			<?= $form->field($model, 'amount_freight')->textInput() ?>

<!-- attribute amount_insurance -->
			<?= $form->field($model, 'amount_insurance')->textInput() ?>

<!-- attribute amount_internal_exp -->
			<?= $form->field($model, 'amount_internal_exp')->textInput() ?>

<!-- attribute amount_total_charges -->
			<?= $form->field($model, 'amount_total_charges')->textInput() ?>

<!-- attribute amount_total -->
			<?= $form->field($model, 'amount_total')->textInput() ?>

<!-- attribute std_price -->
			<?= $form->field($model, 'std_price')->textInput() ?>

<!-- attribute std_amount -->
			<?= $form->field($model, 'std_amount')->textInput() ?>

<!-- attribute order_quantity -->
			<?= $form->field($model, 'order_quantity')->textInput() ?>

<!-- attribute relied_delivery_qty -->
			<?= $form->field($model, 'relied_delivery_qty')->textInput() ?>

<!-- attribute price_act -->
			<?= $form->field($model, 'price_act')->textInput() ?>

<!-- attribute amount_act -->
			<?= $form->field($model, 'amount_act')->textInput() ?>

<!-- attribute variance_act -->
			<?= $form->field($model, 'variance_act')->textInput() ?>

<!-- attribute rcv_date -->
			<?= $form->field($model, 'rcv_date')->textInput() ?>

<!-- attribute order_date -->
			<?= $form->field($model, 'order_date')->textInput() ?>

<!-- attribute order_delivery_date -->
			<?= $form->field($model, 'order_delivery_date')->textInput() ?>

<!-- attribute relied_delivery_date -->
			<?= $form->field($model, 'relied_delivery_date')->textInput() ?>

<!-- attribute bc_date -->
			<?= $form->field($model, 'bc_date')->textInput() ?>

<!-- attribute upload_date -->
			<?= $form->field($model, 'upload_date')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'SapPoRcv'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Create' : 'Save'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

