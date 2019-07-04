<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\date\DatePicker;

/**
* @var yii\web\View $this
* @var app\models\CrusherTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="crusher-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'CrusherTbl',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>

        <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                        'options' => [
                            'type' => DatePicker::TYPE_INPUT,
                        ],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ],
                        'pickerButton' => false,
                    ]); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'model')->dropDownList([
                        'BF 10' => 'BF 10',
                        'BF 15' => 'BF 15',
                        'BF 12' => 'BF 12',
                        'CA 10' => 'CA 10',
                        'CA 12' => 'CA 12',
                        'CA 15' => 'CA 15',
                    ]); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'part')->dropDownList([
                        'Runner' => 'Runner',
                        'Product' => 'Product',
                    ]); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'qty')->textInput(); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'bom')->textInput(); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'consume')->textInput(); ?>
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
            <?= Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

