<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\HrgaSplCodeSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="spl-code-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'KODE_LEMBUR') ?>

		<?= $form->field($model, 'START_LEMBUR_PLAN') ?>

		<?= $form->field($model, 'END_LEMBUR_PLAN') ?>

		<?= $form->field($model, 'NILAI_LEMBUR_PLAN') ?>

		<?= $form->field($model, 'JENIS_LEMBUR') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
