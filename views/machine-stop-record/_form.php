<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;
use app\models\MachineStopRecord;

/**
* @var yii\web\View $this
* @var app\models\MachineStopRecord $model
* @var yii\widgets\ActiveForm $form
*/

$tmp_open = MachineStopRecord::find()->where([
    'STATUS' => 0
])->all();

$dropdown_options = [
    'placeholder' => 'Select a machine ...'
];

if (count($tmp_open) > 0) {
    $disabled_arr = [];
    foreach ($tmp_open as $key => $value) {
        $disabled_arr[$value->MESIN_ID] = ['disabled' => true];
    }
    $dropdown_options['options'] = $disabled_arr;
}


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
                <?= $model->isNewRecord ? $form->field($model, 'MESIN_ID')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\AssetTbl::find()
                        ->where('PATINDEX(\'MNT%\', asset_id) > 0')
                        ->orderBy('computer_name')->all(), 'asset_id', 'assetName'),
                    'options' => $dropdown_options,
                    'value' => date('Y-m-d H:i:s'),
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) : $form->field($model, 'MESIN_DESC')->textInput(['readonly' => true]); ?>
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

        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <?= $model->isNewRecord || $model->STATUS == 0 ? '' : $form->field($model, 'END_TIME')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Enter end time ...'],
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'REMARK')->textArea(['rows' => 3, 'style' => 'resize : none;']); ?>
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

