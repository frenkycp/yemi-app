<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\RdrDprDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="rdr-dpr-data-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'material_document_number') ?>

		<?= $form->field($model, 'material_document_number_barcode') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'rcv_date') ?>

		<?= $form->field($model, 'vendor_code') ?>

		<?php // echo $form->field($model, 'vendor_name') ?>

		<?php // echo $form->field($model, 'pic') ?>

		<?php // echo $form->field($model, 'division') ?>

		<?php // echo $form->field($model, 'NOTE') ?>

		<?php // echo $form->field($model, 'inv_no') ?>

		<?php // echo $form->field($model, 'material') ?>

		<?php // echo $form->field($model, 'description') ?>

		<?php // echo $form->field($model, 'um') ?>

		<?php // echo $form->field($model, 'do_inv_qty') ?>

		<?php // echo $form->field($model, 'act_rcv_qty') ?>

		<?php // echo $form->field($model, 'discrepancy_qty') ?>

		<?php // echo $form->field($model, 'standard_price') ?>

		<?php // echo $form->field($model, 'standard_amount') ?>

		<?php // echo $form->field($model, 'rdr_dpr') ?>

		<?php // echo $form->field($model, 'category') ?>

		<?php // echo $form->field($model, 'normal_urgent') ?>

		<?php // echo $form->field($model, 'user_id') ?>

		<?php // echo $form->field($model, 'user_desc') ?>

		<?php // echo $form->field($model, 'user_issue_date') ?>

		<?php // echo $form->field($model, 'korlap') ?>

		<?php // echo $form->field($model, 'korlap_desc') ?>

		<?php // echo $form->field($model, 'korlap_confirm_date') ?>

		<?php // echo $form->field($model, 'purc_approve') ?>

		<?php // echo $form->field($model, 'purc_approve_desc') ?>

		<?php // echo $form->field($model, 'purc_approve_date') ?>

		<?php // echo $form->field($model, 'discrepancy_treatment') ?>

		<?php // echo $form->field($model, 'payment_treatment') ?>

		<?php // echo $form->field($model, 'purc_approve_remark') ?>

		<?php // echo $form->field($model, 'user_close') ?>

		<?php // echo $form->field($model, 'user_close_desc') ?>

		<?php // echo $form->field($model, 'user_close_date') ?>

		<?php // echo $form->field($model, 'close_open') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
