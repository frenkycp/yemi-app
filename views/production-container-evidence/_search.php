<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ProductionContainerEvidenceSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="serno-output-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'pk') ?>

		<?= $form->field($model, 'uniq') ?>

		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'so') ?>

		<?= $form->field($model, 'stc') ?>

		<?php // echo $form->field($model, 'dst') ?>

		<?php // echo $form->field($model, 'num') ?>

		<?php // echo $form->field($model, 'gmc') ?>

		<?php // echo $form->field($model, 'qty') ?>

		<?php // echo $form->field($model, 'output') ?>

		<?php // echo $form->field($model, 'adv') ?>

		<?php // echo $form->field($model, 'vms') ?>

		<?php // echo $form->field($model, 'etd') ?>

		<?php // echo $form->field($model, 'ship') ?>

		<?php // echo $form->field($model, 'cntr') ?>

		<?php // echo $form->field($model, 'category') ?>

		<?php // echo $form->field($model, 'remark') ?>

		<?php // echo $form->field($model, 'invo') ?>

		<?php // echo $form->field($model, 'cont') ?>

		<?php // echo $form->field($model, 'm3') ?>

		<?php // echo $form->field($model, 'back_order') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
