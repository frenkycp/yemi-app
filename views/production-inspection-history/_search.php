<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ProductionInspectionHistorySearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="serno-input-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= '';$form->field($model, 'num') ?>

		<?= '';$form->field($model, 'pk') ?>

		<?= '';$form->field($model, 'gmc') ?>

		<?= '';$form->field($model, 'line') ?>

		<?= '';$form->field($model, 'proddate') ?>

		<?php // echo $form->field($model, 'waktu') ?>

		<?php // echo $form->field($model, 'sernum') ?>

		<?php // echo $form->field($model, 'flo') ?>

		<?php // echo $form->field($model, 'palletnum') ?>

		<?php // echo $form->field($model, 'plan') ?>

		<?php // echo $form->field($model, 'adv') ?>

		<?php // echo $form->field($model, 'qa_ok') ?>

		<?php // echo $form->field($model, 'qa_ok_date') ?>

		<?php echo $form->field($model, 'qa_ng') ?>

		<?php // echo $form->field($model, 'qa_ng_date') ?>

		<?php // echo $form->field($model, 'qa_result') ?>

		<?php // echo $form->field($model, 'ship') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= '';Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
