<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;

/**
* @var yii\web\View $this
* @var app\models\ShiftPatrolTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="shift-patrol-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ShiftPatrolTbl',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'options' => ['enctype' => 'multipart/form-data'],
    ]
    );
    ?>

    <div ></div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'patrol_time')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => 'Masukkan waktu patrol ...'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'patrol_type')->dropDownList([
                        1 => 'POSITF',
                        2 => 'NEGATIF'
                    ], [
                        'prompt' => '-Pilih Penilaian-'
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'status')->dropDownList([
                        0 => 'OPEN',
                        10 => 'CLOSED',
                    ], [
                        'prompt' => '-Pilih Status-'
                    ]); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'section_id')->dropDownList($section_arr, [
                        'prompt' => '--Select Section--',
                        'onchange' => '
                            $.post( "' . Yii::$app->urlManager->createUrl('ipqa-patrol-tbl/get-cost-center?CC_ID=') . '"+$(this).val(), function( data ) {
                                var data_arr = data.split("||");
                                $( "#txt_dept" ).val(data_arr[0]);
                                $( "#txt_sect" ).val(data_arr[1]);
                            });
                        ',
                    ])->label('Section'); ?>
                    <?= $form->field($model, 'section_group')->hiddenInput(['id' => 'txt_dept'])->label(false); ?>
                    <?= $form->field($model, 'section_desc')->hiddenInput(['id' => 'txt_sect'])->label(false); ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(app\models\ShiftPatrolCategoryTbl::find()->all(), 'id', 'category_desc'), [
                        'prompt' => '-Pilih Topik-'
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'category_detail')->textInput(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'location')->dropDownList($location_arr, [
                        'prompt' => '-Pilih Lokasi-'
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'location_detail')->textInput(); ?>
                </div>
            </div>
            
            <?= $form->field($model, 'description')->textInput() ?>
            <?= $form->field($model, 'action')->textInput() ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <?php
                            echo $model->img_filename1 == null ? 
                            $form->field($model, 'upload_file1')->widget(\kartik\file\FileInput::className(), [
                                'options' => [
                                    'accept' => 'image/*'
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['jpg'],
                                    'showUpload' => false,
                                ],
                            ]) : $form->field($model, 'upload_file1')->widget(\kartik\file\FileInput::className(), [
                                'options' => [
                                    'accept' => 'image/*'
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['jpg'],
                                    'initialPreview' => Url::to('@web/uploads/SHIFT_PATROL/') . $model->img_filename1,
                                    'initialPreviewAsData' => true,
                                    'showUpload' => false,
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <?php
                            echo $model->img_filename2 == null ? 
                            $form->field($model, 'upload_file2')->widget(\kartik\file\FileInput::className(), [
                                'options' => [
                                    'accept' => 'image/*'
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['jpg'],
                                    'showUpload' => false,
                                ],
                            ]) : $form->field($model, 'upload_file2')->widget(\kartik\file\FileInput::className(), [
                                'options' => [
                                    'accept' => 'image/*'
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['jpg'],
                                    'initialPreview' => Url::to('@web/uploads/SHIFT_PATROL/') . $model->img_filename2,
                                    'initialPreviewAsData' => true,
                                    'showUpload' => false,
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <?php echo $form->errorSummary($model); ?>
            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Submit' : 'Save'),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
            );
            ?>
            <?= Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning', 'id' => 'btn-cancel']) ?>

    <?php ActiveForm::end(); ?>

</div>

