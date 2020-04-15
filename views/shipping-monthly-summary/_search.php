<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ShippingMonthlySummarySearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="shipping-monthly-summary-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'final_product_so') ?>

		<?= $form->field($model, 'final_product_act') ?>

		<?= $form->field($model, 'final_product_ratio') ?>

		<?= $form->field($model, 'kd_so') ?>

		<?php // echo $form->field($model, 'kd_act') ?>

		<?php // echo $form->field($model, 'kd_ratio') ?>

		<?php // echo $form->field($model, 'sent_email_datetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
