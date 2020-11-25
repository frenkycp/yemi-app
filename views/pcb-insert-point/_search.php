<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\PcbInsertPointSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="pcb-insert-point-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'part_no') ?>

		<?= $form->field($model, 'model_name') ?>

		<?= $form->field($model, 'pcb') ?>

		<?= $form->field($model, 'destination') ?>

		<?= $form->field($model, 'smt_a') ?>

		<?php // echo $form->field($model, 'smt_b') ?>

		<?php // echo $form->field($model, 'smt') ?>

		<?php // echo $form->field($model, 'jv2') ?>

		<?php // echo $form->field($model, 'av131') ?>

		<?php // echo $form->field($model, 'rg131') ?>

		<?php // echo $form->field($model, 'ai') ?>

		<?php // echo $form->field($model, 'mi') ?>

		<?php // echo $form->field($model, 'total') ?>

		<?php // echo $form->field($model, 'sap_bu') ?>

		<?php // echo $form->field($model, 'price') ?>

		<?php // echo $form->field($model, 'last_update') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
