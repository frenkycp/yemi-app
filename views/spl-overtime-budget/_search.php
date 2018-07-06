<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SplOvertimeBudgetSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="spl-overtime-budget-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'category_id') ?>

		<?= $form->field($model, 'category_desc') ?>

		<?= $form->field($model, 'overtime_budget') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
