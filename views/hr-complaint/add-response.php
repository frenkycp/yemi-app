<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

$this->title = [
    'page_title' => 'My HR <small class="">Add Response</small>',
    'tab_title' => 'My HR',
    'breadcrumbs_title' => 'My HR'
];

?>

<div class="hr-complaint-form">

    <?php $form = ActiveForm::begin([
    'id' => 'HrComplaint',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             /*'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],*/
         ],
    ]
    );
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Add Response
            </h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'nik')->textInput(['readonly' => true]) ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'emp_name')->textInput(['readonly' => true]) ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'department')->textInput(['readonly' => true]) ?>
                </div>
            </div>
            <?= $form->field($model, 'remark')->textarea(['rows' => 6, 'readonly' => true, 'style' => 'resize : none;']) ?>
            <?= $form->field($model, 'response')->textarea(['rows' => 6, 'style' => 'resize : none;']) ?>
            
        </div>
        <div class="panel-footer text-right">
            <?php echo $form->errorSummary($model); ?>

            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
            );
            ?>
        </div>
    </div>

<!-- attribute nik -->
            
        

        

        <?php ActiveForm::end(); ?>


</div>

