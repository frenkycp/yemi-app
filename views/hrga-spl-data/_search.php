<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\HrgaSplDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="spl-hdr-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'SPL_HDR_ID') ?>

		<?= $form->field($model, 'SPL_BARCODE') ?>

		<?= $form->field($model, 'TGL_LEMBUR') ?>

		<?= $form->field($model, 'JENIS_LEMBUR') ?>

		<?= $form->field($model, 'CC_ID') ?>

		<?php // echo $form->field($model, 'CC_GROUP') ?>

		<?php // echo $form->field($model, 'CC_DESC') ?>

		<?php // echo $form->field($model, 'USER_ID') ?>

		<?php // echo $form->field($model, 'USER_DESC') ?>

		<?php // echo $form->field($model, 'USER_LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'DOC_RCV_DATE') ?>

		<?php // echo $form->field($model, 'USER_DOC_RCV') ?>

		<?php // echo $form->field($model, 'USER_DESC_DOC_RCV') ?>

		<?php // echo $form->field($model, 'DOC_VALIDATION_DATE') ?>

		<?php // echo $form->field($model, 'URAIAN_UMUM') ?>

		<?php // echo $form->field($model, 'STAT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
