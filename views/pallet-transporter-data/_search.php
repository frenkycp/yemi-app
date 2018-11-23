<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\PalletTransporterDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="serno-slip-log-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'pk') ?>

		<?= $form->field($model, 'line') ?>

		<?= $form->field($model, 'start') ?>

		<?= $form->field($model, 'end') ?>

		<?= $form->field($model, 'arrival_time') ?>

		<?php // echo $form->field($model, 'nik') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
