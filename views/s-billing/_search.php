<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SBillingSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="supplier-billing-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'no') ?>

		<?= $form->field($model, 'supplier_name') ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'UserName') ?>

		<?= $form->field($model, 'Email') ?>

		<?php // echo $form->field($model, 'supplier_pic') ?>

		<?php // echo $form->field($model, 'receipt_no') ?>

		<?php // echo $form->field($model, 'invoice_no') ?>

		<?php // echo $form->field($model, 'delivery_no') ?>

		<?php // echo $form->field($model, 'tax_no') ?>

		<?php // echo $form->field($model, 'cur') ?>

		<?php // echo $form->field($model, 'amount') ?>

		<?php // echo $form->field($model, 'doc_upload_by') ?>

		<?php // echo $form->field($model, 'doc_upload_date') ?>

		<?php // echo $form->field($model, 'doc_upload_stat') ?>

		<?php // echo $form->field($model, 'doc_received_by') ?>

		<?php // echo $form->field($model, 'doc_received_date') ?>

		<?php // echo $form->field($model, 'doc_received_stat') ?>

		<?php // echo $form->field($model, 'doc_pch_finished_by') ?>

		<?php // echo $form->field($model, 'doc_pch_finished_date') ?>

		<?php // echo $form->field($model, 'doc_pch_finished_stat') ?>

		<?php // echo $form->field($model, 'doc_finance_handover_by') ?>

		<?php // echo $form->field($model, 'doc_finance_handover_date') ?>

		<?php // echo $form->field($model, 'doc_finance_handover_stat') ?>

		<?php // echo $form->field($model, 'document_link') ?>

		<?php // echo $form->field($model, 'stage') ?>

		<?php // echo $form->field($model, 'open_close') ?>

		<?php // echo $form->field($model, 'remark') ?>

		<?php // echo $form->field($model, 'dokumen') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
