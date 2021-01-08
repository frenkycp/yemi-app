<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;

/**
* @var yii\web\View $this
* @var app\models\MachineStopRecord $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="machine-stop-record-form">

    <?php $form = ActiveForm::begin([
    'id' => 'MachineStopRecord',
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
                <div class="col-sm-8">
                    <?= $form->field($model, 'MESIN_ID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\MachineIotCurrent::find()->all(), 'mesin_id', 'assetName'),
                        'options' => ['placeholder' => 'Select a machine ...'],
                        'value' => date('Y-m-d H:i:s'),
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'START_TIME')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Enter start time ...'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]); ?>
                </div>
            </div>
        

        <?php echo $form->errorSummary($model); ?>

        <?= Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Create' : 'Save'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

