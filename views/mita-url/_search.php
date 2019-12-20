<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MitaUrlSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="mita-url-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'url_id') ?>

		<?= $form->field($model, 'location') ?>

		<?= $form->field($model, 'url') ?>

		<?= $form->field($model, 'title') ?>

		<?= $form->field($model, 'order_no') ?>

		<?php // echo $form->field($model, 'flag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
