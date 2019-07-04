<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\CrusherTblSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="crusher-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'trans_id') ?>

		<?= $form->field($model, 'date') ?>

		<?= $form->field($model, 'model') ?>

		<?= $form->field($model, 'part') ?>

		<?= $form->field($model, 'qty') ?>

		<?php // echo $form->field($model, 'bom') ?>

		<?php // echo $form->field($model, 'consume') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
