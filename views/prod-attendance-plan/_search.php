<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ProdAttendancePlanSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="prod-attendance-mp-plan-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'child_analyst') ?>

		<?= $form->field($model, 'child_analyst_desc') ?>

		<?= $form->field($model, 'nik') ?>

		<?= $form->field($model, 'name') ?>

		<?php // echo $form->field($model, 'from_date') ?>

		<?php // echo $form->field($model, 'to_date') ?>

		<?php // echo $form->field($model, 'created_date') ?>

		<?php // echo $form->field($model, 'created_by_id') ?>

		<?php // echo $form->field($model, 'last_update') ?>

		<?php // echo $form->field($model, 'updated_by_id') ?>

		<?php // echo $form->field($model, 'is_enable') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
