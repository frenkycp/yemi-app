<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\TpPartList $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="tp-part-list-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'tp_part_list_id') ?>

		<?= $form->field($model, 'speaker_model') ?>

		<?= $form->field($model, 'part_no') ?>

		<?= $form->field($model, 'part_name') ?>

		<?= $form->field($model, 'rev_no') ?>

		<?php // echo $form->field($model, 'total_product') ?>

		<?php // echo $form->field($model, 'total_assy') ?>

		<?php // echo $form->field($model, 'total_spare_part') ?>

		<?php // echo $form->field($model, 'total_requirement') ?>

		<?php // echo $form->field($model, 'pc_remarks') ?>

		<?php // echo $form->field($model, 'present_po') ?>

		<?php // echo $form->field($model, 'present_due_date') ?>

		<?php // echo $form->field($model, 'present_qty') ?>

		<?php // echo $form->field($model, 'dcn_no') ?>

		<?php // echo $form->field($model, 'part_type') ?>

		<?php // echo $form->field($model, 'part_status') ?>

		<?php // echo $form->field($model, 'caf_no') ?>

		<?php // echo $form->field($model, 'direct_po_trf') ?>

		<?php // echo $form->field($model, 'purch_status') ?>

		<?php // echo $form->field($model, 'pc_status') ?>

		<?php // echo $form->field($model, 'delivery_conf_etd') ?>

		<?php // echo $form->field($model, 'delivery_conf_eta') ?>

		<?php // echo $form->field($model, 'act_delivery_etd') ?>

		<?php // echo $form->field($model, 'act_delivery_eta') ?>

		<?php // echo $form->field($model, 'invoice') ?>

		<?php // echo $form->field($model, 'qty') ?>

		<?php // echo $form->field($model, 'transport_by') ?>

		<?php // echo $form->field($model, 'transportation_cost') ?>

		<?php // echo $form->field($model, 'pe_confirm') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'qa_judgement') ?>

		<?php // echo $form->field($model, 'qa_remark') ?>

		<?php // echo $form->field($model, 'last_modified') ?>

		<?php // echo $form->field($model, 'last_modified_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
