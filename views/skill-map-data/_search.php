<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\SkillMapDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="skill-master-karyawan-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'ID') ?>

		<?= $form->field($model, 'NIK') ?>

		<?= $form->field($model, 'NAMA_KARYAWAN') ?>

		<?= $form->field($model, 'TGL_MASUK_YEMI') ?>

		<?= $form->field($model, 'kelompok') ?>

		<?php // echo $form->field($model, 'skill_id') ?>

		<?php // echo $form->field($model, 'skill_desc') ?>

		<?php // echo $form->field($model, 'skill_group') ?>

		<?php // echo $form->field($model, 'skill_group_desc') ?>

		<?php // echo $form->field($model, 'skill_value') ?>

		<?php // echo $form->field($model, 'WW01') ?>

		<?php // echo $form->field($model, 'WW02') ?>

		<?php // echo $form->field($model, 'WW03') ?>

		<?php // echo $form->field($model, 'WW04') ?>

		<?php // echo $form->field($model, 'WI01') ?>

		<?php // echo $form->field($model, 'WI02') ?>

		<?php // echo $form->field($model, 'WI03') ?>

		<?php // echo $form->field($model, 'WP01') ?>

		<?php // echo $form->field($model, 'WM01') ?>

		<?php // echo $form->field($model, 'WM02') ?>

		<?php // echo $form->field($model, 'WM03') ?>

		<?php // echo $form->field($model, 'WU01') ?>

		<?php // echo $form->field($model, 'WS01') ?>

		<?php // echo $form->field($model, 'WF01') ?>

		<?php // echo $form->field($model, 'TIPE') ?>

		<?php // echo $form->field($model, 'USER_ID') ?>

		<?php // echo $form->field($model, 'USER_DESC') ?>

		<?php // echo $form->field($model, 'USER_LAST_UPDATE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
