<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ClinicDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="klinik-input-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'pk') ?>

		<?= $form->field($model, 'nik') ?>

		<?= $form->field($model, 'nama') ?>

		<?= $form->field($model, 'dept') ?>

		<?= $form->field($model, 'opsi') ?>

		<?php // echo $form->field($model, 'masuk') ?>

		<?php // echo $form->field($model, 'keluar') ?>

		<?php // echo $form->field($model, 'anamnesa') ?>

		<?php // echo $form->field($model, 'root_cause') ?>

		<?php // echo $form->field($model, 'diagnosa') ?>

		<?php // echo $form->field($model, 'obat1') ?>

		<?php // echo $form->field($model, 'obat2') ?>

		<?php // echo $form->field($model, 'obat3') ?>

		<?php // echo $form->field($model, 'obat4') ?>

		<?php // echo $form->field($model, 'obat5') ?>

		<?php // echo $form->field($model, 'handleby') ?>

		<?php // echo $form->field($model, 'confirm') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
