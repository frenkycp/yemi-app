<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var app\models\KlinikInput $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="klinik-input-form">

    <?php $form = ActiveForm::begin([
    'id' => 'KlinikInput',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    ]
    );
    ?>

    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'nik')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                            'NIK', 'NAMA_KARYAWAN'
                        ])
                        ->all(), 'NIK', 'NIK'),
                        'options' => [
                            'placeholder' => 'Select NIK ...',
                            'onchange' => '
                                $.post( "' . Yii::$app->urlManager->createUrl('clinic-data/emp-info?nik=') . '"+$(this).val(), function( data ) {
                                    var data_arr = data.split("||");
                                    $( "#txt_name" ).val(data_arr[0]);
                                    $( "#txt_dept" ).val(data_arr[1]);
                                });
                            ',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'nama')->textInput(['readonly' => true, 'id' => 'txt_name']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'dept')->textInput(['readonly' => true, 'id' => 'txt_dept']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'opsi')->dropDownList([
                        1 => 'PERIKSA',
                        2 => 'ISTIRAHAT SAKIT',
                        3 => 'LAKTASI'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'anamnesa')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'root_cause')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'diagnosa')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Obat</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <?= $form->field($model, 'obat1')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($model, 'obat2')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($model, 'obat3')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($model, 'obat4')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($model, 'obat5')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
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

