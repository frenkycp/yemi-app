<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\HrgaDataKaryawanSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="karyawan-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'NIK') ?>

		<?= $form->field($model, 'NAMA_KARYAWAN') ?>

		<?= $form->field($model, 'TGL_LAHIR') ?>

		<?= $form->field($model, 'JENIS_KELAMIN') ?>

		<?= $form->field($model, 'STATUS_PERKAWINAN') ?>

		<?php // echo $form->field($model, 'ALAMAT') ?>

		<?php // echo $form->field($model, 'ALAMAT_SEMENTARA') ?>

		<?php // echo $form->field($model, 'TELP') ?>

		<?php // echo $form->field($model, 'NPWP') ?>

		<?php // echo $form->field($model, 'KTP') ?>

		<?php // echo $form->field($model, 'BPJS_KESEHATAN') ?>

		<?php // echo $form->field($model, 'BPJS_KETENAGAKERJAAN') ?>

		<?php // echo $form->field($model, 'TGL_MASUK_YEMI') ?>

		<?php // echo $form->field($model, 'STATUS_KARYAWAN') ?>

		<?php // echo $form->field($model, 'CC_ID') ?>

		<?php // echo $form->field($model, 'DEPARTEMEN') ?>

		<?php // echo $form->field($model, 'SECTION') ?>

		<?php // echo $form->field($model, 'SUB_SECTION') ?>

		<?php // echo $form->field($model, 'JABATAN_SR') ?>

		<?php // echo $form->field($model, 'JABATAN_SR_GROUP') ?>

		<?php // echo $form->field($model, 'GRADE') ?>

		<?php // echo $form->field($model, 'DIRECT_INDIRECT') ?>

		<?php // echo $form->field($model, 'JENIS_PEKERJAAN') ?>

		<?php // echo $form->field($model, 'SKILL') ?>

		<?php // echo $form->field($model, 'SERIKAT_PEKERJA') ?>

		<?php // echo $form->field($model, 'KONTRAK_KE') ?>

		<?php // echo $form->field($model, 'K1_START') ?>

		<?php // echo $form->field($model, 'K1_END') ?>

		<?php // echo $form->field($model, 'K2_START') ?>

		<?php // echo $form->field($model, 'K2_END') ?>

		<?php // echo $form->field($model, 'ACTIVE_STAT') ?>

		<?php // echo $form->field($model, 'PASSWORD') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
