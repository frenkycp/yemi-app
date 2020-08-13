<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\DrossOutputSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="dross-output-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'dross') ?>

		<?= $form->field($model, 'dross_recycle') ?>

		<?= $form->field($model, 'mesin') ?>

		<?= $form->field($model, 'tgl') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
