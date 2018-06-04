<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MpInOutSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="mp-in-out-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'MP_ID') ?>

		<?= $form->field($model, 'NIK') ?>

		<?= $form->field($model, 'NAMA_KARYAWAN') ?>

		<?= $form->field($model, 'JENIS_KELAMIN') ?>

		<?= $form->field($model, 'STATUS_KARYAWAN') ?>

		<?php // echo $form->field($model, 'DIRECT_INDIRECT') ?>

		<?php // echo $form->field($model, 'CC_ID') ?>

		<?php // echo $form->field($model, 'DEPARTEMEN') ?>

		<?php // echo $form->field($model, 'SECTION') ?>

		<?php // echo $form->field($model, 'SUB_SECTION') ?>

		<?php // echo $form->field($model, 'KONTRAK_KE') ?>

		<?php // echo $form->field($model, 'PERIOD') ?>

		<?php // echo $form->field($model, 'TANGGAL') ?>

		<?php // echo $form->field($model, 'KONTRAK_START') ?>

		<?php // echo $form->field($model, 'KONTRAK_END') ?>

		<?php // echo $form->field($model, 'SKILL') ?>

		<?php // echo $form->field($model, 'JUMLAH') ?>

		<?php // echo $form->field($model, 'TINGKATAN') ?>

		<?php // echo $form->field($model, 'AKHIR_BULAN') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
