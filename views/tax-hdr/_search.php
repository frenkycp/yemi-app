<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\TaxHdrSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="tax-hdr-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'no_seri') ?>

		<?= $form->field($model, 'no_seri_val') ?>

		<?= $form->field($model, 'kdJenisTransaksi') ?>

		<?= $form->field($model, 'fgPengganti') ?>

		<?= $form->field($model, 'nomorFaktur') ?>

		<?php // echo $form->field($model, 'period') ?>

		<?php // echo $form->field($model, 'tanggalFaktur') ?>

		<?php // echo $form->field($model, 'npwpPenjual') ?>

		<?php // echo $form->field($model, 'namaPenjual') ?>

		<?php // echo $form->field($model, 'alamatPenjual') ?>

		<?php // echo $form->field($model, 'npwpLawanTransaksi') ?>

		<?php // echo $form->field($model, 'namaLawanTransaksi') ?>

		<?php // echo $form->field($model, 'alamatLawanTransaksi') ?>

		<?php // echo $form->field($model, 'jumlahDpp') ?>

		<?php // echo $form->field($model, 'jumlahPpn') ?>

		<?php // echo $form->field($model, 'jumlahPpnBm') ?>

		<?php // echo $form->field($model, 'statusApproval') ?>

		<?php // echo $form->field($model, 'statusFaktur') ?>

		<?php // echo $form->field($model, 'referensi') ?>

		<?php // echo $form->field($model, 'last_updated') ?>

		<?php // echo $form->field($model, 'status_upload') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
