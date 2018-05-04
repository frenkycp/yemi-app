<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SernoOutput $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="serno-output-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'pk') ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'stc') ?>

		<?= $form->field($model, 'dst') ?>

		<?= $form->field($model, 'num') ?>

		<?php // echo $form->field($model, 'gmc') ?>

		<?php // echo $form->field($model, 'qty') ?>

		<?php // echo $form->field($model, 'output') ?>

		<?php // echo $form->field($model, 'adv') ?>

		<?php // echo $form->field($model, 'etd') ?>

		<?php // echo $form->field($model, 'cntr') ?>

		<?php // echo $form->field($model, 'ng') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
