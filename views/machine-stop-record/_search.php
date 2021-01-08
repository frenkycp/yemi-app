<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MachineStopRecordSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="machine-stop-record-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID') ?>

		<?= $form->field($model, 'MESIN_ID') ?>

		<?= $form->field($model, 'MESIN_DESC') ?>

		<?= $form->field($model, 'START_TIME') ?>

		<?= $form->field($model, 'START_BY_ID') ?>

		<?php // echo $form->field($model, 'START_BY_NAME') ?>

		<?php // echo $form->field($model, 'END_TIME') ?>

		<?php // echo $form->field($model, 'END_BY_ID') ?>

		<?php // echo $form->field($model, 'END_BY_NAME') ?>

		<?php // echo $form->field($model, 'CLOSING_TIME') ?>

		<?php // echo $form->field($model, 'CLOSING_BY_ID') ?>

		<?php // echo $form->field($model, 'CLOSING_BY_NAME') ?>

		<?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
