<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\datetime\DateTimePicker;

/**
* @var yii\web\View $this
* @var app\models\MesinCheckNgDtr $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Input Form</h3>
    </div>
    <?php $form = ActiveForm::begin([
    'id' => 'MesinCheckNgDtr',
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

    <div class="box-body">
        <!-- attribute urutan -->
        <?= $form->field($model, 'urutan')->textInput(['readonly' => true]) ?>

        <!-- attribute color_stat -->
        <?= $form->field($model, 'color_stat')->dropDownList([
            1 => 'MASIH DIOPERASIKAN',
            0 => 'STOP'
        ]) ?>

        <!-- attribute down_time -->
        <?= $form->field($model, 'down_time')->textInput(['type' => 'number'])->label('Down Time (min)') ?>

        <!-- attribute stat_last_update -->
        <?= $form->field($model, 'stat_last_update')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Enter Last Update ...'],
            'pluginOptions' => [
                //'autoclose' => true,
                'format' => 'yyyy-mm-dd hh:ii:ss'
            ]
        ]) ?>

        <!-- attribute stat_description -->
        <?= $form->field($model, 'stat_description')->textInput() ?>
        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="box-footer">
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
            ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    
</div>

