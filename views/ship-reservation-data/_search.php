<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ShipReservationDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="ship-reservation-dtr-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'BL_NO') ?>

		<?= $form->field($model, 'RESERVATION_NO') ?>

		<?= $form->field($model, 'HELP') ?>

		<?= $form->field($model, 'STATUS') ?>

		<?= $form->field($model, 'SHIPPER') ?>

		<?php // echo $form->field($model, 'POL') ?>

		<?php // echo $form->field($model, 'POD') ?>

		<?php // echo $form->field($model, 'CNT_40HC') ?>

		<?php // echo $form->field($model, 'CNT_40') ?>

		<?php // echo $form->field($model, 'CNT_20') ?>

		<?php // echo $form->field($model, 'CARRIER') ?>

		<?php // echo $form->field($model, 'FLAG_PRIORTY') ?>

		<?php // echo $form->field($model, 'FLAG_DESC') ?>

		<?php // echo $form->field($model, 'ETD') ?>

		<?php // echo $form->field($model, 'APPLIED_RATE') ?>

		<?php // echo $form->field($model, 'INVOICE') ?>

		<?php // echo $form->field($model, 'NOTE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
