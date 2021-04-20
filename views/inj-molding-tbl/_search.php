<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\InjMoldingTblSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="inj-molding-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'MOLDING_ID') ?>

		<?= $form->field($model, 'MOLDING_NAME') ?>

		<?= $form->field($model, 'MACHINE_ID') ?>

		<?= $form->field($model, 'MACHINE_DESC') ?>

		<?= $form->field($model, 'TOTAL_COUNT') ?>

		<?php // echo $form->field($model, 'TARGET_COUNT') ?>

		<?php // echo $form->field($model, 'MOLDING_STATUS') ?>

		<?php // echo $form->field($model, 'LAST_UPDATE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
