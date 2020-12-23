<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\NgSernoSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="prod-ng-detail-serno-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'SEQ') ?>

		<?= $form->field($model, 'loc_id') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'post_date') ?>

		<?= $form->field($model, 'document_no') ?>

		<?php // echo $form->field($model, 'serial_no') ?>

		<?php // echo $form->field($model, 'img_before') ?>

		<?php // echo $form->field($model, 'img_after') ?>

		<?php // echo $form->field($model, 'create_date') ?>

		<?php // echo $form->field($model, 'last_update') ?>

		<?php // echo $form->field($model, 'repair_id') ?>

		<?php // echo $form->field($model, 'repair_name') ?>

		<?php // echo $form->field($model, 'user_id') ?>

		<?php // echo $form->field($model, 'user_name') ?>

		<?php // echo $form->field($model, 'flag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
