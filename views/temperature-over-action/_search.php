<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\TemperatureOverActionSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="temperature-over-action-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID') ?>

		<?= $form->field($model, 'POST_DATE') ?>

		<?= $form->field($model, 'EMP_ID') ?>

		<?= $form->field($model, 'EMP_NAME') ?>

		<?= $form->field($model, 'SHIFT') ?>

		<?php // echo $form->field($model, 'LAST_CHECK') ?>

		<?php // echo $form->field($model, 'OLD_TEMPERATURE') ?>

		<?php // echo $form->field($model, 'NEW_TEMPERATURE') ?>

		<?php // echo $form->field($model, 'NEXT_ACTION') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
