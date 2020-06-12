<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\XeroxLogSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="fotocopy-log-tbl-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'machine') ?>

		<?= $form->field($model, 'period') ?>

		<?= $form->field($model, 'post_date') ?>

		<?= $form->field($model, 'date_completed') ?>

		<?= $form->field($model, 'NIK') ?>

		<?php // echo $form->field($model, 'NIK_DESC') ?>

		<?php // echo $form->field($model, 'COST_CENTER') ?>

		<?php // echo $form->field($model, 'COST_CENTER_DESC') ?>

		<?php // echo $form->field($model, 'EMAIL_ADDRESS') ?>

		<?php // echo $form->field($model, 'date') ?>

		<?php // echo $form->field($model, 'year') ?>

		<?php // echo $form->field($model, 'month') ?>

		<?php // echo $form->field($model, 'day') ?>

		<?php // echo $form->field($model, 'year_month') ?>

		<?php // echo $form->field($model, 'month_day') ?>

		<?php // echo $form->field($model, 'time_completed') ?>

		<?php // echo $form->field($model, 'job_type') ?>

		<?php // echo $form->field($model, 'job_type_details') ?>

		<?php // echo $form->field($model, 'input_send_type') ?>

		<?php // echo $form->field($model, 'input_port') ?>

		<?php // echo $form->field($model, 'pc_name') ?>

		<?php // echo $form->field($model, 'user_id') ?>

		<?php // echo $form->field($model, 'user_name') ?>

		<?php // echo $form->field($model, 'account_id') ?>

		<?php // echo $form->field($model, 'document_name') ?>

		<?php // echo $form->field($model, 'output_destination') ?>

		<?php // echo $form->field($model, 'page_1') ?>

		<?php // echo $form->field($model, 'pages_2') ?>

		<?php // echo $form->field($model, 'pages_4') ?>

		<?php // echo $form->field($model, 'pages_per_side') ?>

		<?php // echo $form->field($model, 'sided_1') ?>

		<?php // echo $form->field($model, 'sided_2') ?>

		<?php // echo $form->field($model, 'pdl') ?>

		<?php // echo $form->field($model, 'color_a4') ?>

		<?php // echo $form->field($model, 'color_b4') ?>

		<?php // echo $form->field($model, 'color_a3') ?>

		<?php // echo $form->field($model, 'color_letter') ?>

		<?php // echo $form->field($model, 'color_legal') ?>

		<?php // echo $form->field($model, 'color_ledger') ?>

		<?php // echo $form->field($model, 'color_others') ?>

		<?php // echo $form->field($model, 'black_white_a4') ?>

		<?php // echo $form->field($model, 'black_white_b4') ?>

		<?php // echo $form->field($model, 'black_white_a3') ?>

		<?php // echo $form->field($model, 'black_white_letter') ?>

		<?php // echo $form->field($model, 'black_white_legal') ?>

		<?php // echo $form->field($model, 'black_white_ledger') ?>

		<?php // echo $form->field($model, 'black_white_others') ?>

		<?php // echo $form->field($model, 'a4_plain') ?>

		<?php // echo $form->field($model, 'a4_plain_reload') ?>

		<?php // echo $form->field($model, 'a4_others') ?>

		<?php // echo $form->field($model, 'b4_plain') ?>

		<?php // echo $form->field($model, 'b4_plain_reload') ?>

		<?php // echo $form->field($model, 'b4_others') ?>

		<?php // echo $form->field($model, 'a3_plain') ?>

		<?php // echo $form->field($model, 'a3_plain_reload') ?>

		<?php // echo $form->field($model, 'a3_others') ?>

		<?php // echo $form->field($model, 'letter_plain') ?>

		<?php // echo $form->field($model, 'letter_plain_reload') ?>

		<?php // echo $form->field($model, 'letter_others') ?>

		<?php // echo $form->field($model, 'legal_plain') ?>

		<?php // echo $form->field($model, 'legal_plain_reload') ?>

		<?php // echo $form->field($model, 'legal_others') ?>

		<?php // echo $form->field($model, 'ledger_plain') ?>

		<?php // echo $form->field($model, 'ledger_plain_reload') ?>

		<?php // echo $form->field($model, 'ledger_others') ?>

		<?php // echo $form->field($model, 'others_plain') ?>

		<?php // echo $form->field($model, 'others_plain_reload') ?>

		<?php // echo $form->field($model, 'others_others') ?>

		<?php // echo $form->field($model, 'color_original_a4') ?>

		<?php // echo $form->field($model, 'color_original_b4') ?>

		<?php // echo $form->field($model, 'color_original_a3') ?>

		<?php // echo $form->field($model, 'color_original_letter') ?>

		<?php // echo $form->field($model, 'color_original_legal') ?>

		<?php // echo $form->field($model, 'color_original_ledger') ?>

		<?php // echo $form->field($model, 'color_original_others') ?>

		<?php // echo $form->field($model, 'black_white_original_a4') ?>

		<?php // echo $form->field($model, 'black_white_original_b4') ?>

		<?php // echo $form->field($model, 'black_white_original_a3') ?>

		<?php // echo $form->field($model, 'black_white_original_letter') ?>

		<?php // echo $form->field($model, 'black_white_original_legal') ?>

		<?php // echo $form->field($model, 'black_white_original_ledger') ?>

		<?php // echo $form->field($model, 'black_white_original_others') ?>

		<?php // echo $form->field($model, 'job_status') ?>

		<?php // echo $form->field($model, 'fault_code') ?>

		<?php // echo $form->field($model, 'related_job') ?>

		<?php // echo $form->field($model, 'job_number_id1') ?>

		<?php // echo $form->field($model, 'job_number_id2') ?>

		<?php // echo $form->field($model, 'document_number') ?>

		<?php // echo $form->field($model, 'folder_number') ?>

		<?php // echo $form->field($model, 'fax_recipient_name') ?>

		<?php // echo $form->field($model, 'fax_remote_terminal_name') ?>

		<?php // echo $form->field($model, 'fax_remote_id') ?>

		<?php // echo $form->field($model, 'fax_number') ?>

		<?php // echo $form->field($model, 'fax_start_date') ?>

		<?php // echo $form->field($model, 'fax_start_time') ?>

		<?php // echo $form->field($model, 'fax_duration') ?>

		<?php // echo $form->field($model, 'fax_images_sent') ?>

		<?php // echo $form->field($model, 'fax_images_received') ?>

		<?php // echo $form->field($model, 'fax_communication_protocol') ?>

		<?php // echo $form->field($model, 'fax_communication_result') ?>

		<?php // echo $form->field($model, 'total_color_pages') ?>

		<?php // echo $form->field($model, 'total_black_white_pages') ?>

		<?php // echo $form->field($model, 'total_pages') ?>

		<?php // echo $form->field($model, 'total_sheets') ?>

		<?php // echo $form->field($model, 'fax_speed_dial') ?>

		<?php // echo $form->field($model, 'nama_file') ?>

		<?php // echo $form->field($model, 'last_update') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
