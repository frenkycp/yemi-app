<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\PermitDataCenterSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="emp-permit-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID') ?>

		<?= $form->field($model, 'NIK') ?>

		<?= $form->field($model, 'NAMA_KARYAWAN') ?>

		<?= $form->field($model, 'DIVISION') ?>

		<?= $form->field($model, 'DEPARTMENT') ?>

		<?php // echo $form->field($model, 'SECTION') ?>

		<?php // echo $form->field($model, 'COST_CENTER_CODE') ?>

		<?php // echo $form->field($model, 'COST_CENTER_NAME') ?>

		<?php // echo $form->field($model, 'EMPLOY_CODE') ?>

		<?php // echo $form->field($model, 'PERIOD') ?>

		<?php // echo $form->field($model, 'POST_DATE') ?>

		<?php // echo $form->field($model, 'REASON') ?>

		<?php // echo $form->field($model, 'STATUS') ?>

		<?php // echo $form->field($model, 'LAST_UPDATED') ?>

		<?php // echo $form->field($model, 'FLAG') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
