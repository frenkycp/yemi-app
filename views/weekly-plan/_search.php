<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\WeeklyPlanSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="weekly-plan-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'week') ?>

		<?php // echo $form->field($model, 'actual_qty') ?>

		<?php // echo $form->field($model, 'flag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= ''; Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
