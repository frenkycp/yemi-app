<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\CutiTblSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="cuti-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'CUTI_ID') ?>

		<?= $form->field($model, 'NIK') ?>

		<?= $form->field($model, 'NAMA_KARYAWAN') ?>

		<?= $form->field($model, 'CATEGORY') ?>

		<?= $form->field($model, 'TAHUN') ?>

		<?php // echo $form->field($model, 'JUMLAH_CUTI') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
