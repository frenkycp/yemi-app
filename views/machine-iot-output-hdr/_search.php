<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MachineIotOutputHdrSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="machine-iot-output-hdr-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'lot_number') ?>

		<?= $form->field($model, 'gmc') ?>

		<?= $form->field($model, 'gmc_desc') ?>

		<?= $form->field($model, 'lot_qty') ?>

		<?= $form->field($model, 'start_date') ?>

		<?php // echo $form->field($model, 'end_date') ?>

		<?php // echo $form->field($model, 'run_time') ?>

		<?php // echo $form->field($model, 'iddle_time') ?>

		<?php // echo $form->field($model, 'total_lead_time') ?>

		<?php // echo $form->field($model, 'man_power_qty') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
