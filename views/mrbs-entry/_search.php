<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\MrbsEntrySearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="mrbs-entry-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'start_time') ?>

		<?= $form->field($model, 'end_time') ?>

		<?= $form->field($model, 'entry_type') ?>

		<?= $form->field($model, 'repeat_id') ?>

		<?php // echo $form->field($model, 'room_id') ?>

		<?php // echo $form->field($model, 'timestamp') ?>

		<?php // echo $form->field($model, 'create_by') ?>

		<?php // echo $form->field($model, 'modified_by') ?>

		<?php // echo $form->field($model, 'name') ?>

		<?php // echo $form->field($model, 'type') ?>

		<?php // echo $form->field($model, 'description') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'reminded') ?>

		<?php // echo $form->field($model, 'info_time') ?>

		<?php // echo $form->field($model, 'info_user') ?>

		<?php // echo $form->field($model, 'info_text') ?>

		<?php // echo $form->field($model, 'ical_uid') ?>

		<?php // echo $form->field($model, 'ical_sequence') ?>

		<?php // echo $form->field($model, 'ical_recur_id') ?>

		<?php // echo $form->field($model, 'meeting_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
