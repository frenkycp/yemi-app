<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\GoSaTblSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="go-sa-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID') ?>

		<?= $form->field($model, 'REQUESTOR_NIK') ?>

		<?= $form->field($model, 'REQUESTOR_NAME') ?>

		<?= $form->field($model, 'START_TIME') ?>

		<?= $form->field($model, 'END_TIME') ?>

		<?php // echo $form->field($model, 'REMARK') ?>

		<?php // echo $form->field($model, 'TOTAL_MP') ?>

		<?php // echo $form->field($model, 'LT') ?>

		<?php // echo $form->field($model, 'FLAG') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
