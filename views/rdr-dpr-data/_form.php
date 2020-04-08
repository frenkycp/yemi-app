<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\RdrDprData $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="rdr-dpr-data-form">

    <?php $form = ActiveForm::begin([
    'id' => 'RdrDprData',
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
            

<!-- attribute material_document_number -->
			<?= $form->field($model, 'material_document_number')->textInput(['maxlength' => true]) ?>

<!-- attribute rcv_date -->
			<?= $form->field($model, 'rcv_date')->textInput() ?>

<!-- attribute user_issue_date -->
			<?= $form->field($model, 'user_issue_date')->textInput() ?>

<!-- attribute purc_approve_date -->
			<?= $form->field($model, 'purc_approve_date')->textInput() ?>

<!-- attribute user_close_date -->
			<?= $form->field($model, 'user_close_date')->textInput() ?>

<!-- attribute do_inv_qty -->
			<?= $form->field($model, 'do_inv_qty')->textInput() ?>

<!-- attribute act_rcv_qty -->
			<?= $form->field($model, 'act_rcv_qty')->textInput() ?>

<!-- attribute discrepancy_qty -->
			<?= $form->field($model, 'discrepancy_qty')->textInput() ?>

<!-- attribute standard_price -->
			<?= $form->field($model, 'standard_price')->textInput() ?>

<!-- attribute standard_amount -->
			<?= $form->field($model, 'standard_amount')->textInput() ?>

<!-- attribute purc_approve_remark -->
			<?= $form->field($model, 'purc_approve_remark')->textInput() ?>

<!-- attribute material_document_number_barcode -->
			<?= $form->field($model, 'material_document_number_barcode')->textInput(['maxlength' => true]) ?>

<!-- attribute pic -->
			<?= $form->field($model, 'pic')->textInput(['maxlength' => true]) ?>

<!-- attribute division -->
			<?= $form->field($model, 'division')->textInput(['maxlength' => true]) ?>

<!-- attribute NOTE -->
			<?= $form->field($model, 'NOTE')->textInput(['maxlength' => true]) ?>

<!-- attribute user_desc -->
			<?= $form->field($model, 'user_desc')->textInput(['maxlength' => true]) ?>

<!-- attribute korlap_desc -->
			<?= $form->field($model, 'korlap_desc')->textInput(['maxlength' => true]) ?>

<!-- attribute korlap_confirm_date -->
			<?= $form->field($model, 'korlap_confirm_date')->textInput(['maxlength' => true]) ?>

<!-- attribute purc_approve_desc -->
			<?= $form->field($model, 'purc_approve_desc')->textInput(['maxlength' => true]) ?>

<!-- attribute user_close_desc -->
			<?= $form->field($model, 'user_close_desc')->textInput(['maxlength' => true]) ?>

<!-- attribute period -->
			<?= $form->field($model, 'period')->textInput(['maxlength' => true]) ?>

<!-- attribute vendor_code -->
			<?= $form->field($model, 'vendor_code')->textInput(['maxlength' => true]) ?>

<!-- attribute material -->
			<?= $form->field($model, 'material')->textInput(['maxlength' => true]) ?>

<!-- attribute vendor_name -->
			<?= $form->field($model, 'vendor_name')->textInput(['maxlength' => true]) ?>

<!-- attribute inv_no -->
			<?= $form->field($model, 'inv_no')->textInput(['maxlength' => true]) ?>

<!-- attribute description -->
			<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

<!-- attribute rdr_dpr -->
			<?= $form->field($model, 'rdr_dpr')->textInput(['maxlength' => true]) ?>

<!-- attribute category -->
			<?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

<!-- attribute normal_urgent -->
			<?= $form->field($model, 'normal_urgent')->textInput(['maxlength' => true]) ?>

<!-- attribute um -->
			<?= $form->field($model, 'um')->textInput(['maxlength' => true]) ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

<!-- attribute korlap -->
			<?= $form->field($model, 'korlap')->textInput(['maxlength' => true]) ?>

<!-- attribute purc_approve -->
			<?= $form->field($model, 'purc_approve')->textInput(['maxlength' => true]) ?>

<!-- attribute user_close -->
			<?= $form->field($model, 'user_close')->textInput(['maxlength' => true]) ?>

<!-- attribute discrepancy_treatment -->
			<?= $form->field($model, 'discrepancy_treatment')->textInput(['maxlength' => true]) ?>

<!-- attribute payment_treatment -->
			<?= $form->field($model, 'payment_treatment')->textInput(['maxlength' => true]) ?>

<!-- attribute close_open -->
			<?= $form->field($model, 'close_open')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'RdrDprData'),
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

