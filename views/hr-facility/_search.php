<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\HrFacilitySearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="hr-facility-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'input_datetime') ?>

		<?= $form->field($model, 'nik') ?>

		<?= $form->field($model, 'emp_name') ?>

		<?php // echo $form->field($model, 'cc_id') ?>

		<?php // echo $form->field($model, 'dept') ?>

		<?php // echo $form->field($model, 'section') ?>

		<?php // echo $form->field($model, 'facility_name') ?>

		<?php // echo $form->field($model, 'remark') ?>

		<?php // echo $form->field($model, 'remark_category') ?>

		<?php // echo $form->field($model, 'response') ?>

		<?php // echo $form->field($model, 'response_datetime') ?>

		<?php // echo $form->field($model, 'responder_id') ?>

		<?php // echo $form->field($model, 'responder_name') ?>

		<?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
