<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ProdAttendanceDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="prod-attendance-data-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'att_data_id') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'posting_date') ?>

		<?= $form->field($model, 'posting_shift') ?>

		<?= $form->field($model, 'nik') ?>

		<?php // echo $form->field($model, 'name') ?>

		<?php // echo $form->field($model, 'check_in') ?>

		<?php // echo $form->field($model, 'check_out') ?>

		<?php // echo $form->field($model, 'child_analyst') ?>

		<?php // echo $form->field($model, 'child_analyst_desc') ?>

		<?php // echo $form->field($model, 'line') ?>

		<?php // echo $form->field($model, 'machine_id') ?>

		<?php // echo $form->field($model, 'machine_desc') ?>

		<?php // echo $form->field($model, 'last_update') ?>

		<?php // echo $form->field($model, 'current_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
