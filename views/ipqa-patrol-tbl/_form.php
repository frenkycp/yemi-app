<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\SernoMaster;
use kartik\date\DatePicker;
use yii\web\View;

/**
* @var yii\web\View $this
* @var app\models\IpqaPatrolTbl $model
* @var yii\widgets\ActiveForm $form
*/

$script = <<< JS
    $(document).on('beforeSubmit', 'form', function(event) {
        $(this).find('[type=submit]').attr('disabled', true).addClass('disabled');
        $('#btn-cancel').attr('disabled', true).addClass('disabled');
    });
    $(document).ready(function() {
        $('#btn-cancel').click(function(){
            //alert('ok');
            $(document).find('[type=submit]').attr('disabled', true).addClass('disabled');
            $(this).attr('disabled', true).addClass('disabled');
        });
    });
    
JS;
$this->registerJs($script, View::POS_HEAD);

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
                            <?= $form->field($model, 'child')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(app\models\WipHdr::find()
                                    ->select('child, child_desc')
                                    ->groupBy('child, child_desc')
                                    ->orderBy('child_desc')
                                    ->all(), 'child', 'description'),
                                'options' => [
                                    'placeholder' => 'Select Product ...',
                                    'onchange' => '
                                        $.post( "' . Yii::$app->urlManager->createUrl('ipqa-patrol-tbl/get-desc?child=') . '"+$(this).val(), function( data ) {
                                            var data_arr = data.split("||");
                                            $( "#txt_desc" ).val(data_arr[0]);
                                            $( "#txt_loc" ).val(data_arr[1]);
                                            $( "#txt_loc_desc" ).val(data_arr[2]);
                                        });
                                    ',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Part/Product'); ?>
                            <?= $form->field($model, 'child_desc')->hiddenInput(['id' => 'txt_desc'])->label(false); ?>
                            <?= $form->field($model, 'child_analyst')->hiddenInput(['id' => 'txt_loc'])->label(false); ?>
                            <?= $form->field($model, 'child_analyst_desc')->hiddenInput(['id' => 'txt_loc_desc'])->label(false); ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($model, 'CC_ID')->dropDownList($section_arr, [
                                'prompt' => '--Select Section--',
                                'onchange' => '
                                    $.post( "' . Yii::$app->urlManager->createUrl('ipqa-patrol-tbl/get-cost-center?CC_ID=') . '"+$(this).val(), function( data ) {
                                        var data_arr = data.split("||");
                                        $( "#txt_dept" ).val(data_arr[0]);
                                        $( "#txt_sect" ).val(data_arr[1]);
                                    });
                                ',
                            ])->label('Section'); ?>
                            <?= $form->field($model, 'CC_GROUP')->hiddenInput(['id' => 'txt_dept'])->label(false); ?>
                            <?= $form->field($model, 'CC_DESC')->hiddenInput(['id' => 'txt_sect'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <?= $form->field($model, 'line_pic')->textInput([
                                'style' => 'text-transform: uppercase;',
                            ])->label('Line PIC'); ?>
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
                        <div class="col-md-6">
                            <?= $form->field($model, 'rank_category')->dropDownList([
                                'A' => 'A',
                                'B' => 'B',
                            ]); ?>
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
                            <?= $form->field($model, 'description')->textArea(['rows' => 5, 'style' => 'resize: none;']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            echo $model->filename1 == null ? 
                            $form->field($model, 'upload_file1')->widget(\kartik\file\FileInput::className(), [
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
                            ])->label('Attachment') : '<div class="form-group"><label class="control-label">Attachment</label><div class="form-control">' . Html::a('Click here to view attachment ...', Url::to('@web/uploads/IPQA_PATROL/' . $model->filename1), ['target' => '_blank', 'data-pjax' => '0',]) . '</div></div>';
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
            ['class' => 'btn btn-warning', 'id' => 'btn-cancel']) ?>
        </div>
    </div>
        
    <?php ActiveForm::end(); ?>

</div>

