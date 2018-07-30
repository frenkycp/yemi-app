<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MntShiftSchSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="mnt-shift-sch-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'shift_emp_id') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'shift_date') ?>

		<?= $form->field($model, 'shift_code') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
