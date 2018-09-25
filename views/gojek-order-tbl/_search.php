<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\GojekOrderTblSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="gojek-order-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'slip_id') ?>

		<?= $form->field($model, 'item') ?>

		<?= $form->field($model, 'item_desc') ?>

		<?= $form->field($model, 'from_loc') ?>

		<?php // echo $form->field($model, 'to_loc') ?>

		<?php // echo $form->field($model, 'source') ?>

		<?php // echo $form->field($model, 'issued_date') ?>

		<?php // echo $form->field($model, 'daparture_date') ?>

		<?php // echo $form->field($model, 'arrival_date') ?>

		<?php // echo $form->field($model, 'GOJEK_ID') ?>

		<?php // echo $form->field($model, 'GOJEK_DESC') ?>

		<?php // echo $form->field($model, 'GOJEK_VALUE') ?>

		<?php // echo $form->field($model, 'NIK_REQUEST') ?>

		<?php // echo $form->field($model, 'NAMA_KARYAWAN') ?>

		<?php // echo $form->field($model, 'STAT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
