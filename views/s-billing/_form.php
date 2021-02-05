<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\SupplierBilling $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="supplier-billing-form">

    <?php $form = ActiveForm::begin([
    'id' => 'SupplierBilling',
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
            

<!-- attribute no -->
			<?= $form->field($model, 'no')->textInput(['maxlength' => true]) ?>

<!-- attribute id -->
			<?= $form->field($model, 'id')->textInput() ?>

<!-- attribute stage -->
			<?= $form->field($model, 'stage')->textInput() ?>

<!-- attribute amount -->
			<?= $form->field($model, 'amount')->textInput() ?>

<!-- attribute doc_upload_date -->
			<?= $form->field($model, 'doc_upload_date')->textInput() ?>

<!-- attribute doc_received_date -->
			<?= $form->field($model, 'doc_received_date')->textInput() ?>

<!-- attribute doc_pch_finished_date -->
			<?= $form->field($model, 'doc_pch_finished_date')->textInput() ?>

<!-- attribute doc_finance_handover_date -->
			<?= $form->field($model, 'doc_finance_handover_date')->textInput() ?>

<!-- attribute dokumen -->
			<?= $form->field($model, 'dokumen')->textInput() ?>

<!-- attribute UserName -->
			<?= $form->field($model, 'UserName')->textInput(['maxlength' => true]) ?>

<!-- attribute Email -->
			<?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

<!-- attribute supplier_pic -->
			<?= $form->field($model, 'supplier_pic')->textInput(['maxlength' => true]) ?>

<!-- attribute doc_upload_by -->
			<?= $form->field($model, 'doc_upload_by')->textInput(['maxlength' => true]) ?>

<!-- attribute doc_upload_stat -->
			<?= $form->field($model, 'doc_upload_stat')->textInput(['maxlength' => true]) ?>

<!-- attribute doc_received_by -->
			<?= $form->field($model, 'doc_received_by')->textInput(['maxlength' => true]) ?>

<!-- attribute doc_received_stat -->
			<?= $form->field($model, 'doc_received_stat')->textInput(['maxlength' => true]) ?>

<!-- attribute doc_pch_finished_by -->
			<?= $form->field($model, 'doc_pch_finished_by')->textInput(['maxlength' => true]) ?>

<!-- attribute doc_pch_finished_stat -->
			<?= $form->field($model, 'doc_pch_finished_stat')->textInput(['maxlength' => true]) ?>

<!-- attribute doc_finance_handover_by -->
			<?= $form->field($model, 'doc_finance_handover_by')->textInput(['maxlength' => true]) ?>

<!-- attribute doc_finance_handover_stat -->
			<?= $form->field($model, 'doc_finance_handover_stat')->textInput(['maxlength' => true]) ?>

<!-- attribute document_link -->
			<?= $form->field($model, 'document_link')->textInput(['maxlength' => true]) ?>

<!-- attribute open_close -->
			<?= $form->field($model, 'open_close')->textInput(['maxlength' => true]) ?>

<!-- attribute supplier_name -->
			<?= $form->field($model, 'supplier_name')->textInput(['maxlength' => true]) ?>

<!-- attribute receipt_no -->
			<?= $form->field($model, 'receipt_no')->textInput(['maxlength' => true]) ?>

<!-- attribute invoice_no -->
			<?= $form->field($model, 'invoice_no')->textInput(['maxlength' => true]) ?>

<!-- attribute tax_no -->
			<?= $form->field($model, 'tax_no')->textInput(['maxlength' => true]) ?>

<!-- attribute delivery_no -->
			<?= $form->field($model, 'delivery_no')->textInput(['maxlength' => true]) ?>

<!-- attribute cur -->
			<?= $form->field($model, 'cur')->textInput(['maxlength' => true]) ?>

<!-- attribute remark -->
			<?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'SupplierBilling'),
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

