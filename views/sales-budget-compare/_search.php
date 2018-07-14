<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SalesBudgetCompareSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="sales-budget-compare-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ITEM_INDEX') ?>

		<?= $form->field($model, 'ITEM') ?>

		<?= $form->field($model, 'DESC') ?>

		<?= $form->field($model, 'NO') ?>

		<?= $form->field($model, 'MODEL') ?>

		<?php // echo $form->field($model, 'MODEL_GROUP') ?>

		<?php // echo $form->field($model, 'BU') ?>

		<?php // echo $form->field($model, 'TYPE') ?>

		<?php // echo $form->field($model, 'FISCAL') ?>

		<?php // echo $form->field($model, 'PERIOD') ?>

		<?php // echo $form->field($model, 'QTY_BGT') ?>

		<?php // echo $form->field($model, 'AMOUNT_BGT') ?>

		<?php // echo $form->field($model, 'QTY_ACT_FOR') ?>

		<?php // echo $form->field($model, 'AMOUNT_ACT_FOR') ?>

		<?php // echo $form->field($model, 'QTY_BALANCE') ?>

		<?php // echo $form->field($model, 'AMOUNT_BALANCE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
