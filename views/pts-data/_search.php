<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\PtsDataSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="sap-picking-list-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'barcode') ?>

		<?= $form->field($model, 'set_list_no') ?>

		<?= $form->field($model, 'no') ?>

		<?= $form->field($model, 'Id') ?>

		<?= $form->field($model, 'parent') ?>

		<?php // echo $form->field($model, 'parent_desc') ?>

		<?php // echo $form->field($model, 'parent_um') ?>

		<?php // echo $form->field($model, 'parent_valcl') ?>

		<?php // echo $form->field($model, 'child') ?>

		<?php // echo $form->field($model, 'child_desc') ?>

		<?php // echo $form->field($model, 'child_um') ?>

		<?php // echo $form->field($model, 'valcl') ?>

		<?php // echo $form->field($model, 'req_date') ?>

		<?php // echo $form->field($model, 'plan_qty') ?>

		<?php // echo $form->field($model, 'qty') ?>

		<?php // echo $form->field($model, 'req_qty') ?>

		<?php // echo $form->field($model, 'issue_type') ?>

		<?php // echo $form->field($model, 'pic') ?>

		<?php // echo $form->field($model, 'rack_no') ?>

		<?php // echo $form->field($model, 'loc') ?>

		<?php // echo $form->field($model, 'analyst') ?>

		<?php // echo $form->field($model, 'analyst_desc') ?>

		<?php // echo $form->field($model, 'last_update') ?>

		<?php // echo $form->field($model, 'user_id') ?>

		<?php // echo $form->field($model, 'user_desc') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'tahap') ?>

		<?php // echo $form->field($model, 'add_slip') ?>

		<?php // echo $form->field($model, 'barcode_label') ?>

		<?php // echo $form->field($model, 'compl_qty') ?>

		<?php // echo $form->field($model, 'bo_qty') ?>

		<?php // echo $form->field($model, 'last_update1') ?>

		<?php // echo $form->field($model, 'user_id1') ?>

		<?php // echo $form->field($model, 'user_desc1') ?>

		<?php // echo $form->field($model, 'add_date') ?>

		<?php // echo $form->field($model, 'posting_date') ?>

		<?php // echo $form->field($model, 'storage') ?>

		<?php // echo $form->field($model, 'pts') ?>

		<?php // echo $form->field($model, 'PUR_LOC') ?>

		<?php // echo $form->field($model, 'PUR_LOC_DESC') ?>

		<?php // echo $form->field($model, 'pic_delivery') ?>

		<?php // echo $form->field($model, 'division') ?>

		<?php // echo $form->field($model, 'pts_print') ?>

		<?php // echo $form->field($model, 'hand') ?>

		<?php // echo $form->field($model, 'req_date_ori') ?>

		<?php // echo $form->field($model, 'eta_desc') ?>

		<?php // echo $form->field($model, 'eta_qty') ?>

		<?php // echo $form->field($model, 'eta_time') ?>

		<?php // echo $form->field($model, 'trans_mthd') ?>

		<?php // echo $form->field($model, 'wh_note') ?>

		<?php // echo $form->field($model, 'pch_note') ?>

		<?php // echo $form->field($model, 'stat_ok_ng') ?>

		<?php // echo $form->field($model, 'user_pts') ?>

		<?php // echo $form->field($model, 'user_desc_pts') ?>

		<?php // echo $form->field($model, 'last_update_pts') ?>

		<?php // echo $form->field($model, 'sap_post_date_sinkron') ?>

		<?php // echo $form->field($model, 'mrp') ?>

		<?php // echo $form->field($model, 'dcn_note') ?>

		<?php // echo $form->field($model, 'wh_valid') ?>

		<?php // echo $form->field($model, 'release_date') ?>

		<?php // echo $form->field($model, 'release_user') ?>

		<?php // echo $form->field($model, 'release_user_desc') ?>

		<?php // echo $form->field($model, 'VMS_PERIOD') ?>

		<?php // echo $form->field($model, 'VMS_DATE') ?>

		<?php // echo $form->field($model, 'hapus') ?>

		<?php // echo $form->field($model, 'hand_scan') ?>

		<?php // echo $form->field($model, 'hand_scan_datetime') ?>

		<?php // echo $form->field($model, 'hand_scan_user') ?>

		<?php // echo $form->field($model, 'hand_scan_desc') ?>

		<?php // echo $form->field($model, 'cek') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
