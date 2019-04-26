<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\SernoMaster;
use kartik\date\DatePicker;
use yii\web\View;

/**
* @var yii\web\View $this
* @var app\models\IpqaPatrolTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="ipqa-patrol-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'IpqaPatrolTbl',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'options' => ['enctype' => 'multipart/form-data']
    ]
    );
    ?>

    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'event_date')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Enter date ...'],
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($model, 'inspector_id')->hiddenInput()->label(false); ?>
                            <?= $form->field($model, 'inspector_name')->textInput(['readonly' => 'readonly']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'gmc')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(SernoMaster::find()
                                    ->orderBy('model, color, dest')
                                    ->all(), 'gmc', 'description'),
                                'options' => [
                                    'placeholder' => 'Select Model ...',
                                    'onchange' => '
                                        $.post( "' . Yii::$app->urlManager->createUrl('ipqa-patrol-tbl/gmc-info?gmc=') . '"+$(this).val(), function( data ) {
                                            var data_arr = data.split("||");
                                            $( "#txt_model" ).val(data_arr[0]);
                                            $( "#txt_color" ).val(data_arr[1]);
                                            $( "#txt_destination" ).val(data_arr[2]);
                                        });
                                    ',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                            <?= $form->field($model, 'model_name')->hiddenInput(['id' => 'txt_model'])->label(false); ?>
                            <?= $form->field($model, 'color')->hiddenInput(['id' => 'txt_color'])->label(false); ?>
                            <?= $form->field($model, 'destination')->hiddenInput(['id' => 'txt_destination'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($model, 'line_pic')->textInput([
                                'style' => 'text-transform: uppercase;',
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(app\models\IpqaCategoryTbl::find()->select('category')->where(['flag' => 1])->groupBy('category')->orderBy('category')->all(), 'category', 'category'), [
                                'prompt'=>'-Choose a Category-',
                                'id' => 'category',
                                'onchange'=>'
                                $.post( "'.Yii::$app->urlManager->createUrl('ipqa-patrol-tbl/lists?category=').'"+$(this).val(), function( data ) {
                                    $( "select#problem" ).html( data );
                                });
                                ']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $arr = [];
                            if (!$model->isNewRecord) {
                                $arr = ArrayHelper::map(app\models\IpqaCategoryTbl::find()->select('problem')->where(['category' => $model->category])->groupBy('problem')->orderBy('problem')->all(), 'problem', 'problem');
                            }
                            echo $form->field($model, 'problem')->dropDownList($arr, [
                                //'prompt'=>'-Choose a Problem-',
                                'id' => 'problem',
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'description')->textArea(['rows' => 3, 'style' => 'resize: none;']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            echo $form->field($model, 'upload_file1')->widget(\kartik\file\FileInput::className(), [
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['jpg'],
                                    'showPreview' => false,
                                    'showCaption' => true,
                                    'showRemove' => true,
                                    'showUpload' => false,
                                    //'browseClass' => 'btn btn-primary btn-block',
                                    //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                    //'browseLabel' =>  ' Select Photo'
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="panel-footer">
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
            ['class' => 'btn btn-warning']) ?>
        </div>
    </div>
        
    <?php ActiveForm::end(); ?>

</div>

