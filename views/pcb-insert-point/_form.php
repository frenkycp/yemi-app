<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\PcbInsertPoint $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="pcb-insert-point-form">

    <?php $form = ActiveForm::begin([
    'id' => 'PcbInsertPoint',
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
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'part_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'model_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'pcb')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'destination')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'smt_a')->textInput(['type' => 'number']) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'smt_b')->textInput(['type' => 'number']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($model, 'jv2')->textInput(['type' => 'number']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'av131')->textInput(['type' => 'number']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'rg131')->textInput(['type' => 'number']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'mi')->textInput(['type' => 'number']) ?>
                </div>
            </div>
            <?php echo $form->errorSummary($model); ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
            );
            ?>

            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>
        </div>
    </div>
    <div class="">
            

<!-- attribute part_no -->
			

<!-- attribute smt_a -->
			

<!-- attribute smt_b -->
			

<!-- attribute jv2 -->
			

<!-- attribute av131 -->
			

<!-- attribute rg131 -->
			


<!-- attribute model_name -->
			

<!-- attribute pcb -->
			

<!-- attribute destination -->
			

<!-- attribute sap_bu -->
        

        

        

        <?php ActiveForm::end(); ?>

    </div>

</div>

