<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\JobOrderSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="job-order-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'JOB_ORDER_NO') ?>

		<?= $form->field($model, 'JOB_ORDER_BARCODE') ?>

		<?= $form->field($model, 'LOC') ?>

		<?= $form->field($model, 'LOC_DESC') ?>

		<?= $form->field($model, 'LINE') ?>

		<?php // echo $form->field($model, 'SCH_DATE') ?>

		<?php // echo $form->field($model, 'NIK') ?>

		<?php // echo $form->field($model, 'NAMA_KARYAWAN') ?>

		<?php // echo $form->field($model, 'SMT_SHIFT') ?>

		<?php // echo $form->field($model, 'KELOMPOK') ?>

		<?php // echo $form->field($model, 'MAN_POWER') ?>

		<?php // echo $form->field($model, 'ITEM') ?>

		<?php // echo $form->field($model, 'ITEM_DESC') ?>

		<?php // echo $form->field($model, 'UM') ?>

		<?php // echo $form->field($model, 'MODEL') ?>

		<?php // echo $form->field($model, 'DESTINATION') ?>

		<?php // echo $form->field($model, 'LOT_QTY') ?>

		<?php // echo $form->field($model, 'ORDER_QTY') ?>

		<?php // echo $form->field($model, 'COMMIT_QTY') ?>

		<?php // echo $form->field($model, 'OPEN_QTY') ?>

		<?php // echo $form->field($model, 'START_DATE') ?>

		<?php // echo $form->field($model, 'PAUSE_DATE') ?>

		<?php // echo $form->field($model, 'CONTINUED_DATE') ?>

		<?php // echo $form->field($model, 'END_DATE') ?>

		<?php // echo $form->field($model, 'STD_TIME_VAR') ?>

		<?php // echo $form->field($model, 'STD_TIME') ?>

		<?php // echo $form->field($model, 'INSERT_POINT_VAR') ?>

		<?php // echo $form->field($model, 'INSERT_POINT') ?>

		<?php // echo $form->field($model, 'LOST_TIME') ?>

		<?php // echo $form->field($model, 'USER_ID') ?>

		<?php // echo $form->field($model, 'USER_DESC') ?>

		<?php // echo $form->field($model, 'LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'STAGE') ?>

		<?php // echo $form->field($model, 'STATUS') ?>

		<?php // echo $form->field($model, 'JOB_ORDER_LOT_NO') ?>

		<?php // echo $form->field($model, 'USER_ID_START') ?>

		<?php // echo $form->field($model, 'USER_DESC_START') ?>

		<?php // echo $form->field($model, 'USER_ID_PAUSE') ?>

		<?php // echo $form->field($model, 'USER_DESC_PAUSE') ?>

		<?php // echo $form->field($model, 'USER_ID_CONTINUED') ?>

		<?php // echo $form->field($model, 'USER_DESC_CONTINUED') ?>

		<?php // echo $form->field($model, 'USER_ID_ENDED') ?>

		<?php // echo $form->field($model, 'USER_DESC_ENDED') ?>

		<?php // echo $form->field($model, 'NOTE') ?>

		<?php // echo $form->field($model, 'NOTE2') ?>

		<?php // echo $form->field($model, 'CONFORWARD') ?>

		<?php // echo $form->field($model, 'CONFORWARD_PRINT') ?>

		<?php // echo $form->field($model, 'DANDORI') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
