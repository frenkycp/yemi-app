<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\VmsPlanActualSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="vms-plan-actual-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID') ?>

		<?= $form->field($model, 'ID_PERIOD') ?>

		<?= $form->field($model, 'PRODUCT_TYPE') ?>

		<?= $form->field($model, 'BU') ?>

		<?= $form->field($model, 'LINE') ?>

		<?php // echo $form->field($model, 'MODEL') ?>

		<?php // echo $form->field($model, 'FG_KD') ?>

		<?php // echo $form->field($model, 'ITEM') ?>

		<?php // echo $form->field($model, 'ITEM_DESC') ?>

		<?php // echo $form->field($model, 'DESTINATION') ?>

		<?php // echo $form->field($model, 'VMS_PERIOD') ?>

		<?php // echo $form->field($model, 'VMS_DAY') ?>

		<?php // echo $form->field($model, 'VMS_DATE') ?>

		<?php // echo $form->field($model, 'PLAN_QTY') ?>

		<?php // echo $form->field($model, 'ACTUAL_QTY') ?>

		<?php // echo $form->field($model, 'BALANCE_QTY') ?>

		<?php // echo $form->field($model, 'VMS_VERSION') ?>

		<?php // echo $form->field($model, 'SEESION_NO') ?>

		<?php // echo $form->field($model, 'SESSION_DATE') ?>

		<?php // echo $form->field($model, 'ACT_QTY_LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'LINE_LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'PCUT') ?>

		<?php // echo $form->field($model, 'NOTE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
