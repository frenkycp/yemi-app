<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\AssetTblSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="asset-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'asset_id') ?>

		<?= $form->field($model, 'qr') ?>

		<?= $form->field($model, 'ip_address') ?>

		<?= $form->field($model, 'computer_name') ?>

		<?= $form->field($model, 'jenis') ?>

		<?php // echo $form->field($model, 'manufacture') ?>

		<?php // echo $form->field($model, 'manufacture_desc') ?>

		<?php // echo $form->field($model, 'cpu_desc') ?>

		<?php // echo $form->field($model, 'ram_desc') ?>

		<?php // echo $form->field($model, 'rom_desc') ?>

		<?php // echo $form->field($model, 'os_desc') ?>

		<?php // echo $form->field($model, 'nik') ?>

		<?php // echo $form->field($model, 'NAMA_KARYAWAN') ?>

		<?php // echo $form->field($model, 'fixed_asst_account') ?>

		<?php // echo $form->field($model, 'purchase_date') ?>

		<?php // echo $form->field($model, 'report_type') ?>

		<?php // echo $form->field($model, 'LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'network') ?>

		<?php // echo $form->field($model, 'display') ?>

		<?php // echo $form->field($model, 'camera') ?>

		<?php // echo $form->field($model, 'battery') ?>

		<?php // echo $form->field($model, 'note') ?>

		<?php // echo $form->field($model, 'location') ?>

		<?php // echo $form->field($model, 'area') ?>

		<?php // echo $form->field($model, 'department_pic') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
