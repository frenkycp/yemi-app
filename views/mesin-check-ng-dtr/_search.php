<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MesinCheckNgDtrSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="mesin-check-ng-dtr-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'SEQ') ?>

		<?= $form->field($model, 'urutan') ?>

		<?= $form->field($model, 'color_stat') ?>

		<?= $form->field($model, 'stat_last_update') ?>

		<?= $form->field($model, 'down_time') ?>

		<?php // echo $form->field($model, 'stat_description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
