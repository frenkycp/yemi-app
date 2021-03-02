<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\InterviewYubisashiDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="emp-interview-yubisashi-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID') ?>

		<?= $form->field($model, 'EMP_ID') ?>

		<?= $form->field($model, 'EMP_NAME') ?>

		<?= $form->field($model, 'FISCAL_YEAR') ?>

		<?= $form->field($model, 'DEPARTMENT') ?>

		<?php // echo $form->field($model, 'COST_CENTER_CODE') ?>

		<?php // echo $form->field($model, 'COST_CENTER_NAME') ?>

		<?php // echo $form->field($model, 'YAMAHA_DIAMOND') ?>

		<?php // echo $form->field($model, 'K3') ?>

		<?php // echo $form->field($model, 'SLOGAN_KUALITAS') ?>

		<?php // echo $form->field($model, 'KESELAMATAN_LALU_LINTAS') ?>

		<?php // echo $form->field($model, 'KOMITMENT_BERKENDARA') ?>

		<?php // echo $form->field($model, 'BUDAYA_KERJA') ?>

		<?php // echo $form->field($model, 'LAST_UPDATE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
