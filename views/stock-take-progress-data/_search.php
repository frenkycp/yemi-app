<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\StockTakeProgressDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="store-onhand-wsus-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ITEM') ?>

		<?= $form->field($model, 'ITEM_DESC') ?>

		<?= $form->field($model, 'UM') ?>

		<?= $form->field($model, 'STD_PRICE') ?>

		<?= $form->field($model, 'PI_VALUE') ?>

		<?php // echo $form->field($model, 'ONHAND_QTY') ?>

		<?php // echo $form->field($model, 'PI_VARIANCE') ?>

		<?php // echo $form->field($model, 'PI_VARIANCE_ABSOLUTE') ?>

		<?php // echo $form->field($model, 'ONHAND_AMT') ?>

		<?php // echo $form->field($model, 'PI_VALUE_AMT') ?>

		<?php // echo $form->field($model, 'PI_VARIANCE_AMT') ?>

		<?php // echo $form->field($model, 'PI_VARIANCE_ABSOLUTE_AMT') ?>

		<?php // echo $form->field($model, 'PI_RATE') ?>

		<?php // echo $form->field($model, 'PI_COUNT_1') ?>

		<?php // echo $form->field($model, 'PI_COUNT_2') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_1') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_2') ?>

		<?php // echo $form->field($model, 'PI_PERIOD') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'PI_STAT') ?>

		<?php // echo $form->field($model, 'PI_DUMMY') ?>

		<?php // echo $form->field($model, 'model') ?>

		<?php // echo $form->field($model, 'LOC_ONHAND_QTY') ?>

		<?php // echo $form->field($model, 'BALANCE') ?>

		<?php // echo $form->field($model, 'VMS_VERSION') ?>

		<?php // echo $form->field($model, 'MAT_CLASS') ?>

		<?php // echo $form->field($model, 'category') ?>

		<?php // echo $form->field($model, 'dandory_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
