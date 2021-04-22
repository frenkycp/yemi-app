<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\KlinikObatLogSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="klinik-obat-log-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'klinik_input_pk') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'post_date') ?>

		<?= $form->field($model, 'input_datetime') ?>

		<?php // echo $form->field($model, 'user_id') ?>

		<?php // echo $form->field($model, 'user_name') ?>

		<?php // echo $form->field($model, 'part_no') ?>

		<?php // echo $form->field($model, 'part_desc') ?>

		<?php // echo $form->field($model, 'qty') ?>

		<?php // echo $form->field($model, 'flag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
