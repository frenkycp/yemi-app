<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/

$this->title = [
    'page_title' => 'Final Assy WIP Data (CREATED) <span class="text-green japanesse"></span>',
    'tab_title' => 'Final Assy WIP Data (CREATED)',
    'breadcrumbs_title' => 'Final Assy WIP Data (CREATED)'
];
?>
<div class="giiant-crud cuti-tbl-update">

    <div class="cuti-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'WipPlanActualReport',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    /*'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],
         ],*/
    ]
    );
    ?>

    <div class="">

<!-- attribute NIK -->
			<?= $form->field($model, 'slip_id')->textInput(['readonly' => true])->label('Slip Number') ?>
			<?= $form->field($model, 'model_group')->textInput(['readonly' => true])->label('Model') ?>
			<?= $form->field($model, 'child')->textInput(['readonly' => true])->label('Part Number') ?>
			<?= $form->field($model, 'child_desc')->textInput(['readonly' => true])->label('Part Description') ?>
			<?= $form->field($model, 'summary_qty')->textInput(['type' => 'number', 'readonly' => true])->label('Total Qty') ?>
			<?= $form->field($model, 'complete_qty')->textInput(['type' => 'number'])->label('Complete Qty') ?>
        
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> COMPLETE',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span> Cancel</button>

    </div>

</div>

</div>
