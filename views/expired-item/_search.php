<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ExpiredItemSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="trace-item-dtr-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'SERIAL_NO') ?>

		<?= $form->field($model, 'ITEM') ?>

		<?= $form->field($model, 'ITEM_DESC') ?>

		<?= $form->field($model, 'SUPPLIER') ?>

		<?= $form->field($model, 'SUPPLIER_DESC') ?>

		<?php // echo $form->field($model, 'UM') ?>

		<?php // echo $form->field($model, 'LOT_NO') ?>

		<?php // echo $form->field($model, 'RECEIVED_DATE') ?>

		<?php // echo $form->field($model, 'SURAT_JALAN') ?>

		<?php // echo $form->field($model, 'MANUFACTURED_DATE') ?>

		<?php // echo $form->field($model, 'EXPIRED_DATE') ?>

		<?php // echo $form->field($model, 'EXPIRED_REVISION_NO') ?>

		<?php // echo $form->field($model, 'LIFE_TIME') ?>

		<?php // echo $form->field($model, 'BENTUK_KEMASAN') ?>

		<?php // echo $form->field($model, 'ISI_DALAM_KEMASAN') ?>

		<?php // echo $form->field($model, 'NILAI_INVENTORY') ?>

		<?php // echo $form->field($model, 'STD_PRICE') ?>

		<?php // echo $form->field($model, 'STD_AMT') ?>

		<?php // echo $form->field($model, 'USER_ID') ?>

		<?php // echo $form->field($model, 'USER_DESC') ?>

		<?php // echo $form->field($model, 'LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'AVAILABLE') ?>

		<?php // echo $form->field($model, 'CATEGORY') ?>

		<?php // echo $form->field($model, 'LOC') ?>

		<?php // echo $form->field($model, 'LOC_DESC') ?>

		<?php // echo $form->field($model, 'POST_DATE') ?>

		<?php // echo $form->field($model, 'PERIOD') ?>

		<?php // echo $form->field($model, 'ID_STOK') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
