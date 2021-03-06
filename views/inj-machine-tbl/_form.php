<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var app\models\InjMachineTbl $model
* @var yii\widgets\ActiveForm $form
*/
$css_string = "
    .content-header {display: none;}";
$this->registerCss($css_string);
?>

<div class="inj-machine-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'InjMachineTbl',
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
    <div class="panel-heading">
        <h3 class="panel-title">Machine Data (<?= ($model->isNewRecord ? 'Create' : 'Update') ?>)</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'MACHINE_ID')->textInput(['readonly' => true]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'MACHINE_DESC')->textInput(['readonly' => true]) ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, 'TOTAL_COUNT')->textInput(['type' => 'number', 'readonly' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'MOLDING_ID')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\InjMoldingTbl::find()
                        ->orderBy('MOLDING_NAME')
                        ->all(), 'MOLDING_ID', 'fullDesc'),
                        'options' => [
                            'placeholder' => 'Select Molding',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                ]); ?>
            </div>
            <div class="col-sm-9">
                <?= $form->field($model, 'ITEM')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\SapItemTbl::find()
                        ->select(['material', 'material_description'])
                        ->where(['sloc' => ['WI01', 'WI02', 'WI03']])
                        ->orderBy('material_description')
                        ->all(), 'material', 'fullDescription'),
                        'options' => [
                            'placeholder' => 'Select Item',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                ]); ?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?php echo $form->errorSummary($model); ?>

        <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>

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

        <?php ActiveForm::end(); ?>

    </div>

</div>

