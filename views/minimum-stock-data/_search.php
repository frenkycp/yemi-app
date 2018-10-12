<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MinimumStockDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="minimum-stock-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID_ITEM_LOC') ?>

		<?= $form->field($model, 'ITEM') ?>

		<?= $form->field($model, 'ITEM_EQ_DESC_01') ?>

		<?= $form->field($model, 'ITEM_EQ_UM') ?>

		<?= $form->field($model, 'LOC') ?>

		<?php // echo $form->field($model, 'LOC_DESC') ?>

		<?php // echo $form->field($model, 'MIN_STOCK_QTY') ?>

		<?php // echo $form->field($model, 'PIC') ?>

		<?php // echo $form->field($model, 'PIC_DESC') ?>

		<?php // echo $form->field($model, 'DEP') ?>

		<?php // echo $form->field($model, 'DEP_DESC') ?>

		<?php // echo $form->field($model, 'HIGH_RISK') ?>

		<?php // echo $form->field($model, 'CATEGORY') ?>

		<?php // echo $form->field($model, 'USER_ID') ?>

		<?php // echo $form->field($model, 'USER_DESC') ?>

		<?php // echo $form->field($model, 'LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'MACHINE') ?>

		<?php // echo $form->field($model, 'MACHINE_NAME') ?>

		<?php // echo $form->field($model, 'RACK') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
