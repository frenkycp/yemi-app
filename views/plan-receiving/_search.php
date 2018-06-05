<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\PlanReceivingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-receiving-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'vendor_name') ?>

    <?= $form->field($model, 'vehicle') ?>

    <?= $form->field($model, 'item_type') ?>

    <?= $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'receiving_date') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
