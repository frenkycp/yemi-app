<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MesinCheckResultSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="mesin-check-result-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'urutan') ?>

		<?= $form->field($model, 'location') ?>

		<?= $form->field($model, 'area') ?>

		<?= $form->field($model, 'mesin_id') ?>

		<?= $form->field($model, 'mesin_nama') ?>

		<?php // echo $form->field($model, 'mesin_no') ?>

		<?php // echo $form->field($model, 'mesin_bagian') ?>

		<?php // echo $form->field($model, 'mesin_bagian_ket') ?>

		<?php // echo $form->field($model, 'mesin_status') ?>

		<?php // echo $form->field($model, 'mesin_catatan') ?>

		<?php // echo $form->field($model, 'mesin_periode') ?>

		<?php // echo $form->field($model, 'user_id') ?>

		<?php // echo $form->field($model, 'user_desc') ?>

		<?php // echo $form->field($model, 'mesin_last_update') ?>

		<?php // echo $form->field($model, 'hasil_ok') ?>

		<?php // echo $form->field($model, 'hasil_ng') ?>

		<?php // echo $form->field($model, 'total_cek') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
