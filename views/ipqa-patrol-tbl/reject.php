<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\CutiTbl $model
*/

$this->title = [
    'page_title' => 'Reject Data <span class="text-green japanesse"></span>',
    'tab_title' => 'Reject Data',
    'breadcrumbs_title' => 'Reject Data'
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
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'event_date')->textInput(['readonly' => 'readonly']); ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'child')->textInput(['readonly' => 'readonly'])->label('Part/Product'); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'child_desc')->textInput(['readonly' => 'readonly'])->label('Description'); ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'category')->textInput(['readonly' => 'readonly']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'problem')->textInput(['readonly' => 'readonly']); ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($model, 'description')->textArea(['rows' => 5, 'readonly' => 'readonly']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'cause')->textArea(['rows' => 4, 'placeholder' => 'Input Cause Here ...', 'readonly' => 'readonly'])->label('Cause'); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'countermeasure')->textArea(['rows' => 4, 'placeholder' => 'Input Countermeasure Here ...', 'readonly' => 'readonly'])->label('Countermeasure'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'reject_remark')->textArea(['rows' => 4, 'placeholder' => 'Input Reject Remark Here ...'])->label('Reject Remark'); ?>
            </div>
        </div>
			
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="fa fa-fw fa-ban"></span> REJECT',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-danger'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>
        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span> Cancel</button>

    </div>

</div>

</div>
