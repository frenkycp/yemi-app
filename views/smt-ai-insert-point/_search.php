<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SmtAiInsertPointSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="smt-ai-insert-point-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'PART_NO') ?>

		<?= $form->field($model, 'PARENT_PART_NO') ?>

		<?= $form->field($model, 'POINT_SMT') ?>

		<?= $form->field($model, 'POINT_RG') ?>

		<?= $form->field($model, 'POINT_AV') ?>

		<?php // echo $form->field($model, 'POINT_JV') ?>

		<?php // echo $form->field($model, 'POINT_TOTAL') ?>

		<?php // echo $form->field($model, 'LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'FLAG') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
