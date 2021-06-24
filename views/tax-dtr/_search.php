<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\TaxDtrSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="tax-dtr-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'dtrid') ?>

		<?= $form->field($model, 'no_seri') ?>

		<?= $form->field($model, 'no') ?>

		<?= $form->field($model, 'nama') ?>

		<?= $form->field($model, 'hargaSatuan') ?>

		<?php // echo $form->field($model, 'jumlahBarang') ?>

		<?php // echo $form->field($model, 'hargaTotal') ?>

		<?php // echo $form->field($model, 'diskon') ?>

		<?php // echo $form->field($model, 'dpp') ?>

		<?php // echo $form->field($model, 'ppn') ?>

		<?php // echo $form->field($model, 'tarifPpnbm') ?>

		<?php // echo $form->field($model, 'ppnbm') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
