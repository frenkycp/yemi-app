<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\AuditPatrolSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="audit-patrol-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID') ?>

		<?= $form->field($model, 'PATROL_PERIOD') ?>

		<?= $form->field($model, 'PATROL_DATE') ?>

		<?= $form->field($model, 'PATROL_DATETIME') ?>

		<?= $form->field($model, 'LOC_ID') ?>

		<?php // echo $form->field($model, 'LOC_DESC') ?>

		<?php // echo $form->field($model, 'LOC_DETAIL') ?>

		<?php // echo $form->field($model, 'CATEGORY') ?>

		<?php // echo $form->field($model, 'TOPIC') ?>

		<?php // echo $form->field($model, 'DESCRIPTION') ?>

		<?php // echo $form->field($model, 'ACTION') ?>

		<?php // echo $form->field($model, 'AUDITOR') ?>

		<?php // echo $form->field($model, 'AUDITEE') ?>

		<?php // echo $form->field($model, 'PIC_ID') ?>

		<?php // echo $form->field($model, 'PIC_NAME') ?>

		<?php // echo $form->field($model, 'USER_ID') ?>

		<?php // echo $form->field($model, 'USER_NAME') ?>

		<?php // echo $form->field($model, 'IMAGE_BEFORE') ?>

		<?php // echo $form->field($model, 'IMAGE_AFTER') ?>

		<?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
