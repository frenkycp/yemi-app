<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\IpqaPatrolTblSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="ipqa-patrol-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'event_date') ?>

		<?= $form->field($model, 'gmc') ?>

		<?= $form->field($model, 'model_name') ?>

		<?php // echo $form->field($model, 'color') ?>

		<?php // echo $form->field($model, 'destination') ?>

		<?php // echo $form->field($model, 'category') ?>

		<?php // echo $form->field($model, 'problem') ?>

		<?php // echo $form->field($model, 'description') ?>

		<?php // echo $form->field($model, 'inspector_id') ?>

		<?php // echo $form->field($model, 'inspector_name') ?>

		<?php // echo $form->field($model, 'cause') ?>

		<?php // echo $form->field($model, 'countermeasure') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'input_datetime') ?>

		<?php // echo $form->field($model, 'close_datetime') ?>

		<?php // echo $form->field($model, 'flag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
