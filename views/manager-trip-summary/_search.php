<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ManagerTripSummarySearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="bentol-manager-trip-summary-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'post_date') ?>

		<?= $form->field($model, 'emp_id') ?>

		<?= $form->field($model, 'emp_name') ?>

		<?php // echo $form->field($model, 'account_type') ?>

		<?php // echo $form->field($model, 'start_status') ?>

		<?php // echo $form->field($model, 'end_status') ?>

		<?php // echo $form->field($model, 'start_validation') ?>

		<?php // echo $form->field($model, 'end_validation') ?>

		<?php // echo $form->field($model, 'status_last_update') ?>

		<?php // echo $form->field($model, 'validation_last_update') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
