<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ScrapRequestSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="trace-item-scrap-search">

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

		<?php // echo $form->field($model, 'QTY') ?>

		<?php // echo $form->field($model, 'EXPIRED_DATE') ?>

		<?php // echo $form->field($model, 'LATEST_EXPIRED_DATE') ?>

		<?php // echo $form->field($model, 'USER_ID') ?>

		<?php // echo $form->field($model, 'USER_DESC') ?>

		<?php // echo $form->field($model, 'USER_LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'STATUS') ?>

		<?php // echo $form->field($model, 'CLOSE_BY_ID') ?>

		<?php // echo $form->field($model, 'CLOSE_BY_NAME') ?>

		<?php // echo $form->field($model, 'CLOSE_DATETIME') ?>

		<?php // echo $form->field($model, 'REMARK') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
