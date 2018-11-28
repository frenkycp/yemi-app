<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\UserSupplementSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="user-supplement-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id_user') ?>

		<?= $form->field($model, 'username') ?>

		<?= $form->field($model, 'nm_user') ?>

		<?= $form->field($model, 'password') ?>

		<?= $form->field($model, 'level') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
