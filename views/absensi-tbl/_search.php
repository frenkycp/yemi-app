<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\AbsensiTblSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="absensi-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'NIK_DATE_ID') ?>

		<?= $form->field($model, 'NO') ?>

		<?= $form->field($model, 'NIK') ?>

		<?= $form->field($model, 'CC_ID') ?>

		<?= $form->field($model, 'SECTION') ?>

		<?php // echo $form->field($model, 'DIRECT_INDIRECT') ?>

		<?php // echo $form->field($model, 'NAMA_KARYAWAN') ?>

		<?php // echo $form->field($model, 'YEAR') ?>

		<?php // echo $form->field($model, 'PERIOD') ?>

		<?php // echo $form->field($model, 'WEEK') ?>

		<?php // echo $form->field($model, 'DATE') ?>

		<?php // echo $form->field($model, 'NOTE') ?>

		<?php // echo $form->field($model, 'DAY_STAT') ?>

		<?php // echo $form->field($model, 'CATEGORY') ?>

		<?php // echo $form->field($model, 'TOTAL_KARYAWAN') ?>

		<?php // echo $form->field($model, 'KEHADIRAN') ?>

		<?php // echo $form->field($model, 'BONUS') ?>

		<?php // echo $form->field($model, 'DISIPLIN') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
