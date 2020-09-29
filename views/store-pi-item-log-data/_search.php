<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\StorePiItemLogDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="store-pi-item-log-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID') ?>

		<?= $form->field($model, 'SLIP') ?>

		<?= $form->field($model, 'SLIP_INT') ?>

		<?= $form->field($model, 'SESSION') ?>

		<?= $form->field($model, 'BARCODE') ?>

		<?php // echo $form->field($model, 'BARCODE_QTY') ?>

		<?php // echo $form->field($model, 'PI_PERIOD') ?>

		<?php // echo $form->field($model, 'ITEM') ?>

		<?php // echo $form->field($model, 'ITEM_DESC') ?>

		<?php // echo $form->field($model, 'UM') ?>

		<?php // echo $form->field($model, 'AREA') ?>

		<?php // echo $form->field($model, 'STORAGE') ?>

		<?php // echo $form->field($model, 'STORAGE_DESC') ?>

		<?php // echo $form->field($model, 'PIC') ?>

		<?php // echo $form->field($model, 'RACK') ?>

		<?php // echo $form->field($model, 'RACK_LOC') ?>

		<?php // echo $form->field($model, 'PI_VALUE') ?>

		<?php // echo $form->field($model, 'PI_CREATED_BY') ?>

		<?php // echo $form->field($model, 'PI_CREATED') ?>

		<?php // echo $form->field($model, 'PI_COUNT_01') ?>

		<?php // echo $form->field($model, 'PI_COUNT_01_ID') ?>

		<?php // echo $form->field($model, 'PI_COUNT_01_DESC') ?>

		<?php // echo $form->field($model, 'PI_COUNT_01_PROGRESS') ?>

		<?php // echo $form->field($model, 'PI_COUNT_01_STAT') ?>

		<?php // echo $form->field($model, 'PI_COUNT_01_TIMER') ?>

		<?php // echo $form->field($model, 'PI_COUNT_01_TIMER_SECOND') ?>

		<?php // echo $form->field($model, 'PI_COUNT_01_LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'PI_COUNT_02') ?>

		<?php // echo $form->field($model, 'PI_COUNT_02_ID') ?>

		<?php // echo $form->field($model, 'PI_COUNT_02_DESC') ?>

		<?php // echo $form->field($model, 'PI_COUNT_02_PROGRESS') ?>

		<?php // echo $form->field($model, 'PI_COUNT_02_STAT') ?>

		<?php // echo $form->field($model, 'PI_COUNT_02_TIMER') ?>

		<?php // echo $form->field($model, 'PI_COUNT_02_TIMER_SECOND') ?>

		<?php // echo $form->field($model, 'PI_COUNT_02_LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_01') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_01_ID') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_01_DESC') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_01_PROGRESS') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_01_STAT') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_01_TIMER') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_01_TIMER_SECOND') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_01_LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_02') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_02_ID') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_02_DESC') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_02_PROGRESS') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_02_STAT') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_02_TIMER') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_02_TIMER_SECOND') ?>

		<?php // echo $form->field($model, 'PI_AUDIT_02_LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'Q01_NO') ?>

		<?php // echo $form->field($model, 'Q01_QTY') ?>

		<?php // echo $form->field($model, 'Q01_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_01') ?>

		<?php // echo $form->field($model, 'Q02_NO') ?>

		<?php // echo $form->field($model, 'Q02_QTY') ?>

		<?php // echo $form->field($model, 'Q02_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_02') ?>

		<?php // echo $form->field($model, 'Q03_NO') ?>

		<?php // echo $form->field($model, 'Q03_QTY') ?>

		<?php // echo $form->field($model, 'Q03_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_03') ?>

		<?php // echo $form->field($model, 'Q04_NO') ?>

		<?php // echo $form->field($model, 'Q04_QTY') ?>

		<?php // echo $form->field($model, 'Q04_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_04') ?>

		<?php // echo $form->field($model, 'Q05_NO') ?>

		<?php // echo $form->field($model, 'Q05_QTY') ?>

		<?php // echo $form->field($model, 'Q05_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_05') ?>

		<?php // echo $form->field($model, 'Q06_NO') ?>

		<?php // echo $form->field($model, 'Q06_QTY') ?>

		<?php // echo $form->field($model, 'Q06_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_06') ?>

		<?php // echo $form->field($model, 'Q07_NO') ?>

		<?php // echo $form->field($model, 'Q07_QTY') ?>

		<?php // echo $form->field($model, 'Q07_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_07') ?>

		<?php // echo $form->field($model, 'Q08_NO') ?>

		<?php // echo $form->field($model, 'Q08_QTY') ?>

		<?php // echo $form->field($model, 'Q08_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_08') ?>

		<?php // echo $form->field($model, 'Q09_NO') ?>

		<?php // echo $form->field($model, 'Q09_QTY') ?>

		<?php // echo $form->field($model, 'Q09_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_09') ?>

		<?php // echo $form->field($model, 'Q10_NO') ?>

		<?php // echo $form->field($model, 'Q10_QTY') ?>

		<?php // echo $form->field($model, 'Q10_TOT') ?>

		<?php // echo $form->field($model, 'NOTE_10') ?>

		<?php // echo $form->field($model, 'SLIP_STAT') ?>

		<?php // echo $form->field($model, 'PI_STAGE') ?>

		<?php // echo $form->field($model, 'PI_DUMMY') ?>

		<?php // echo $form->field($model, 'PI_MISTAKE') ?>

		<?php // echo $form->field($model, 'CATEGORY') ?>

		<?php // echo $form->field($model, 'SLIP_SAP') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
