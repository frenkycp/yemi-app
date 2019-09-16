<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MachineIotOutputDtrSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="machine-iot-output-dtr-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'trans_id') ?>

		<?= $form->field($model, 'lot_number') ?>

		<?= $form->field($model, 'seq') ?>

		<?= $form->field($model, 'mesin_id') ?>

		<?= $form->field($model, 'mesin_description') ?>

		<?php // echo $form->field($model, 'kelompok') ?>

		<?php // echo $form->field($model, 'gmc') ?>

		<?php // echo $form->field($model, 'gmc_desc') ?>

		<?php // echo $form->field($model, 'lot_qty') ?>

		<?php // echo $form->field($model, 'start_date') ?>

		<?php // echo $form->field($model, 'end_date') ?>

		<?php // echo $form->field($model, 'lead_time') ?>

		<?php // echo $form->field($model, 'man_power_qty') ?>

		<?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
