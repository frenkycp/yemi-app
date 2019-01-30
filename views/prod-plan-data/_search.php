<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\ProdPlanDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="wip-eff-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'lot_id') ?>

		<?= $form->field($model, 'child_analyst') ?>

		<?= $form->field($model, 'child_analyst_desc') ?>

		<?= $form->field($model, 'LINE') ?>

		<?= $form->field($model, 'SMT_SHIFT') ?>

		<?php // echo $form->field($model, 'KELOMPOK') ?>

		<?php // echo $form->field($model, 'slip_id_01') ?>

		<?php // echo $form->field($model, 'child_01') ?>

		<?php // echo $form->field($model, 'child_desc_01') ?>

		<?php // echo $form->field($model, 'act_qty_01') ?>

		<?php // echo $form->field($model, 'std_time_01') ?>

		<?php // echo $form->field($model, 'slip_id_02') ?>

		<?php // echo $form->field($model, 'child_02') ?>

		<?php // echo $form->field($model, 'child_desc_02') ?>

		<?php // echo $form->field($model, 'act_qty_02') ?>

		<?php // echo $form->field($model, 'std_time_02') ?>

		<?php // echo $form->field($model, 'slip_id_03') ?>

		<?php // echo $form->field($model, 'child_03') ?>

		<?php // echo $form->field($model, 'child_desc_03') ?>

		<?php // echo $form->field($model, 'act_qty_03') ?>

		<?php // echo $form->field($model, 'std_time_03') ?>

		<?php // echo $form->field($model, 'slip_id_04') ?>

		<?php // echo $form->field($model, 'child_04') ?>

		<?php // echo $form->field($model, 'child_desc_04') ?>

		<?php // echo $form->field($model, 'act_qty_04') ?>

		<?php // echo $form->field($model, 'std_time_04') ?>

		<?php // echo $form->field($model, 'slip_id_05') ?>

		<?php // echo $form->field($model, 'child_05') ?>

		<?php // echo $form->field($model, 'child_desc_05') ?>

		<?php // echo $form->field($model, 'act_qty_05') ?>

		<?php // echo $form->field($model, 'std_time_05') ?>

		<?php // echo $form->field($model, 'slip_id_06') ?>

		<?php // echo $form->field($model, 'child_06') ?>

		<?php // echo $form->field($model, 'child_desc_06') ?>

		<?php // echo $form->field($model, 'act_qty_06') ?>

		<?php // echo $form->field($model, 'std_time_06') ?>

		<?php // echo $form->field($model, 'slip_id_07') ?>

		<?php // echo $form->field($model, 'child_07') ?>

		<?php // echo $form->field($model, 'child_desc_07') ?>

		<?php // echo $form->field($model, 'act_qty_07') ?>

		<?php // echo $form->field($model, 'std_time_07') ?>

		<?php // echo $form->field($model, 'slip_id_08') ?>

		<?php // echo $form->field($model, 'child_08') ?>

		<?php // echo $form->field($model, 'child_desc_08') ?>

		<?php // echo $form->field($model, 'act_qty_08') ?>

		<?php // echo $form->field($model, 'std_time_08') ?>

		<?php // echo $form->field($model, 'slip_id_09') ?>

		<?php // echo $form->field($model, 'child_09') ?>

		<?php // echo $form->field($model, 'child_desc_09') ?>

		<?php // echo $form->field($model, 'act_qty_09') ?>

		<?php // echo $form->field($model, 'std_time_09') ?>

		<?php // echo $form->field($model, 'slip_id_10') ?>

		<?php // echo $form->field($model, 'child_10') ?>

		<?php // echo $form->field($model, 'child_desc_10') ?>

		<?php // echo $form->field($model, 'act_qty_10') ?>

		<?php // echo $form->field($model, 'std_time_10') ?>

		<?php // echo $form->field($model, 'child_all') ?>

		<?php // echo $form->field($model, 'child_desc_all') ?>

		<?php // echo $form->field($model, 'qty_all') ?>

		<?php // echo $form->field($model, 'std_all') ?>

		<?php // echo $form->field($model, 'lt_gross') ?>

		<?php // echo $form->field($model, 'lt_loss') ?>

		<?php // echo $form->field($model, 'lt_nett') ?>

		<?php // echo $form->field($model, 'lt_std') ?>

		<?php // echo $form->field($model, 'efisiensi_gross') ?>

		<?php // echo $form->field($model, 'efisiensi') ?>

		<?php // echo $form->field($model, 'start_date') ?>

		<?php // echo $form->field($model, 'end_date') ?>

		<?php // echo $form->field($model, 'post_date') ?>

		<?php // echo $form->field($model, 'period') ?>

		<?php // echo $form->field($model, 'long01') ?>

		<?php // echo $form->field($model, 'long02') ?>

		<?php // echo $form->field($model, 'long03') ?>

		<?php // echo $form->field($model, 'long04') ?>

		<?php // echo $form->field($model, 'long05') ?>

		<?php // echo $form->field($model, 'long06') ?>

		<?php // echo $form->field($model, 'long07') ?>

		<?php // echo $form->field($model, 'long08') ?>

		<?php // echo $form->field($model, 'long09') ?>

		<?php // echo $form->field($model, 'long10') ?>

		<?php // echo $form->field($model, 'long11') ?>

		<?php // echo $form->field($model, 'long12') ?>

		<?php // echo $form->field($model, 'long13') ?>

		<?php // echo $form->field($model, 'long14') ?>

		<?php // echo $form->field($model, 'long15') ?>

		<?php // echo $form->field($model, 'long16') ?>

		<?php // echo $form->field($model, 'long17') ?>

		<?php // echo $form->field($model, 'long18') ?>

		<?php // echo $form->field($model, 'long_total') ?>

		<?php // echo $form->field($model, 'break_time') ?>

		<?php // echo $form->field($model, 'nozzle_maintenance') ?>

		<?php // echo $form->field($model, 'change_schedule') ?>

		<?php // echo $form->field($model, 'air_pressure_problem') ?>

		<?php // echo $form->field($model, 'power_failure') ?>

		<?php // echo $form->field($model, 'part_shortage') ?>

		<?php // echo $form->field($model, 'set_up_1st_time_running_tp') ?>

		<?php // echo $form->field($model, 'part_arrangement_dcn') ?>

		<?php // echo $form->field($model, 'meeting') ?>

		<?php // echo $form->field($model, 'dandori') ?>

		<?php // echo $form->field($model, 'porgram_error') ?>

		<?php // echo $form->field($model, 'm_c_problem') ?>

		<?php // echo $form->field($model, 'feeder_problem') ?>

		<?php // echo $form->field($model, 'quality_problem') ?>

		<?php // echo $form->field($model, 'pcb_transfer_problem') ?>

		<?php // echo $form->field($model, 'profile_problem') ?>

		<?php // echo $form->field($model, 'pick_up_error') ?>

		<?php // echo $form->field($model, 'other') ?>

		<?php // echo $form->field($model, 'USER_ID') ?>

		<?php // echo $form->field($model, 'USER_DESC') ?>

		<?php // echo $form->field($model, 'LAST_UPDATE') ?>

		<?php // echo $form->field($model, 'note01') ?>

		<?php // echo $form->field($model, 'note02') ?>

		<?php // echo $form->field($model, 'note03') ?>

		<?php // echo $form->field($model, 'note04') ?>

		<?php // echo $form->field($model, 'note05') ?>

		<?php // echo $form->field($model, 'note06') ?>

		<?php // echo $form->field($model, 'note07') ?>

		<?php // echo $form->field($model, 'note08') ?>

		<?php // echo $form->field($model, 'note09') ?>

		<?php // echo $form->field($model, 'note10') ?>

		<?php // echo $form->field($model, 'note11') ?>

		<?php // echo $form->field($model, 'note12') ?>

		<?php // echo $form->field($model, 'note13') ?>

		<?php // echo $form->field($model, 'note14') ?>

		<?php // echo $form->field($model, 'note15') ?>

		<?php // echo $form->field($model, 'note16') ?>

		<?php // echo $form->field($model, 'note17') ?>

		<?php // echo $form->field($model, 'note18') ?>

		<?php // echo $form->field($model, 'post_date_original') ?>

		<?php // echo $form->field($model, 'period_original') ?>

		<?php // echo $form->field($model, 'plan_item') ?>

		<?php // echo $form->field($model, 'plan_qty') ?>

		<?php // echo $form->field($model, 'plan_date') ?>

		<?php // echo $form->field($model, 'plan_balance') ?>

		<?php // echo $form->field($model, 'plan_stats') ?>

		<?php // echo $form->field($model, 'plan_run') ?>

		<?php // echo $form->field($model, 'slip_count') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
