<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\HrLoginLogSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="hr-login-log-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'nik') ?>

		<?= $form->field($model, 'emp_name') ?>

		<?= $form->field($model, 'department') ?>

		<?= $form->field($model, 'section') ?>

		<?php // echo $form->field($model, 'sub_section') ?>

		<?php // echo $form->field($model, 'period') ?>

		<?php // echo $form->field($model, 'login_date') ?>

		<?php // echo $form->field($model, 'last_login') ?>

		<?php // echo $form->field($model, 'login_count') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
