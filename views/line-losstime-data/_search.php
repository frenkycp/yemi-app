<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\LineLosstimeDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="serno-losstime-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'pk') ?>

		<?= $form->field($model, 'line') ?>

		<?= $form->field($model, 'mp') ?>

		<?= $form->field($model, 'proddate') ?>

		<?= $form->field($model, 'start_time') ?>

		<?php // echo $form->field($model, 'end_time') ?>

		<?php // echo $form->field($model, 'losstime') ?>

		<?php // echo $form->field($model, 'category') ?>

		<?php // echo $form->field($model, 'model') ?>

		<?php // echo $form->field($model, 'hp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
