<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\VisualPickingListSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="visual-picking-list-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'seq_no') ?>

		<?= $form->field($model, 'set_list_no') ?>

		<?= $form->field($model, 'parent') ?>

		<?= $form->field($model, 'parent_desc') ?>

		<?= $form->field($model, 'parent_um') ?>

		<?php // echo $form->field($model, 'req_date') ?>

		<?php // echo $form->field($model, 'req_date_original') ?>

		<?php // echo $form->field($model, 'plan_qty') ?>

		<?php // echo $form->field($model, 'part_count') ?>

		<?php // echo $form->field($model, 'part_count_fix') ?>

		<?php // echo $form->field($model, 'man_power') ?>

		<?php // echo $form->field($model, 'analyst') ?>

		<?php // echo $form->field($model, 'analyst_desc') ?>

		<?php // echo $form->field($model, 'create_date') ?>

		<?php // echo $form->field($model, 'create_user_id') ?>

		<?php // echo $form->field($model, 'create_user_desc') ?>

		<?php // echo $form->field($model, 'confirm_date') ?>

		<?php // echo $form->field($model, 'confirm_user_id') ?>

		<?php // echo $form->field($model, 'confirm_user_desc') ?>

		<?php // echo $form->field($model, 'start_date') ?>

		<?php // echo $form->field($model, 'start_user_id') ?>

		<?php // echo $form->field($model, 'start_user_desc') ?>

		<?php // echo $form->field($model, 'completed_date') ?>

		<?php // echo $form->field($model, 'completed_user_id') ?>

		<?php // echo $form->field($model, 'completed_user_desc') ?>

		<?php // echo $form->field($model, 'hand_over_date') ?>

		<?php // echo $form->field($model, 'hand_over_user_id') ?>

		<?php // echo $form->field($model, 'hand_over_user_desc') ?>

		<?php // echo $form->field($model, 'priority') ?>

		<?php // echo $form->field($model, 'stage_id') ?>

		<?php // echo $form->field($model, 'stage_desc') ?>

		<?php // echo $form->field($model, 'condition_desc') ?>

		<?php // echo $form->field($model, 'progress_pct') ?>

		<?php // echo $form->field($model, 'stat') ?>

		<?php // echo $form->field($model, 'catatan') ?>

		<?php // echo $form->field($model, 'pts_part') ?>

		<?php // echo $form->field($model, 'pick_lt') ?>

		<?php // echo $form->field($model, 'pts_stat') ?>

		<?php // echo $form->field($model, 'set_list_type') ?>

		<?php // echo $form->field($model, 'delay_days') ?>

		<?php // echo $form->field($model, 'id_01') ?>

		<?php // echo $form->field($model, 'id_01_desc') ?>

		<?php // echo $form->field($model, 'id_02') ?>

		<?php // echo $form->field($model, 'id_02_desc') ?>

		<?php // echo $form->field($model, 'id_03') ?>

		<?php // echo $form->field($model, 'id_03_desc') ?>

		<?php // echo $form->field($model, 'id_04') ?>

		<?php // echo $form->field($model, 'id_04_desc') ?>

		<?php // echo $form->field($model, 'id_05') ?>

		<?php // echo $form->field($model, 'id_05_desc') ?>

		<?php // echo $form->field($model, 'id_06') ?>

		<?php // echo $form->field($model, 'id_06_desc') ?>

		<?php // echo $form->field($model, 'id_07') ?>

		<?php // echo $form->field($model, 'id_07_desc') ?>

		<?php // echo $form->field($model, 'id_08') ?>

		<?php // echo $form->field($model, 'id_08_desc') ?>

		<?php // echo $form->field($model, 'id_09') ?>

		<?php // echo $form->field($model, 'id_09_desc') ?>

		<?php // echo $form->field($model, 'id_10') ?>

		<?php // echo $form->field($model, 'id_10_desc') ?>

		<?php // echo $form->field($model, 'id_update') ?>

		<?php // echo $form->field($model, 'id_update_desc') ?>

		<?php // echo $form->field($model, 'id_update_date') ?>

		<?php // echo $form->field($model, 'sudah_cetak') ?>

		<?php // echo $form->field($model, 'id_prioty') ?>

		<?php // echo $form->field($model, 'id_prioty_desc') ?>

		<?php // echo $form->field($model, 'id_prioty_date') ?>

		<?php // echo $form->field($model, 'id_hc') ?>

		<?php // echo $form->field($model, 'id_hc_desc') ?>

		<?php // echo $form->field($model, 'id_hc_date') ?>

		<?php // echo $form->field($model, 'id_hc_stat') ?>

		<?php // echo $form->field($model, 'id_hc_open') ?>

		<?php // echo $form->field($model, 'id_hc_open_desc') ?>

		<?php // echo $form->field($model, 'id_hc_open_date') ?>

		<?php // echo $form->field($model, 'id_hc_open_stat') ?>

		<?php // echo $form->field($model, 'pts_note') ?>

		<?php // echo $form->field($model, 'slip_count') ?>

		<?php // echo $form->field($model, 'slip_open') ?>

		<?php // echo $form->field($model, 'slip_close') ?>

		<?php // echo $form->field($model, 'show') ?>

		<?php // echo $form->field($model, 'closing_date') ?>

		<?php // echo $form->field($model, 'back_up_period') ?>

		<?php // echo $form->field($model, 'back_up') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
