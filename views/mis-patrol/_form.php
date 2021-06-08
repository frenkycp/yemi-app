<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var app\models\AuditPatrolTbl $model
* @var yii\widgets\ActiveForm $form
*/

//$karyawan_dropdown = ArrayHelper::map(app\models\AuditPatrolPic::find()->orderBy('PIC_NAME')->all(), 'PIC_ID', 'PIC_NAME');
$karyawan_dropdown = ArrayHelper::map(app\models\SunfishViewEmp::find()->select([
    'Emp_no', 'Full_name'
])
->where([
    'status' => 1
])
->andWhere('PATINDEX(\'YE%\', Emp_no) > 0')
->andWhere('PATINDEX(\'M%\', grade_code) = 0')
->andWhere('PATINDEX(\'D%\', grade_code) = 0')
->all(), 'Emp_no', 'nikNama');
$tmp_patrol_category = \Yii::$app->params['mis_patrol_category'];
//asort($tmp_patrol_category);
$tmp_patrol_loc = ArrayHelper::map(app\models\CovidPatrolLoc::find()->all(), 'LOC_ID', 'LOC_NAME');

$this->registerJs("$(document).ready(function() {
    $('#loc_id').trigger('change');
    $('#loading').hide();
});");
?>

<div class="audit-patrol-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'AuditPatrolTbl',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             /*'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],*/
         ],
    ]
    );
    ?>

    <div class="">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($model, 'PATROL_DATE')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Enter date ...'],
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'TOPIC')->dropDownList($tmp_patrol_category)->label('Patrol Category'); ?>
                    </div>
                    <div class="col-sm-5">
                        <?= $form->field($model, 'LOC_ID')->dropDownList($tmp_patrol_loc, [
                            'id' => 'loc_id',
                            'onchange' => '
                                var loc_id = $(this).val();
                                $("#loading").show();
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax-repository/covid-patrol-loc?LOC_ID=') . '"+loc_id, function(data) {
                                    $("#loc_name").val(data.loc_name);
                                });
                                $("#loading").hide();
                            ',
                        ])->label('Location'); ?>
                        <?= $form->field($model, 'LOC_DESC')->hiddenInput(['id' => 'loc_name'])->label(false) ?>
                        
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <?= $form->field($model, 'LOC_DETAIL')->textInput(['id' => 'loc_detail'])->label('Location Detail'); ?>
                    </div>
                    <div class="col-sm-9">
                        <?= $form->field($model, 'DESCRIPTION')->textInput() ?>
                    </div>
                </div>

                <?php
                echo $form->field($model, 'upload_before_1')->widget(\kartik\file\FileInput::className(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  ' Select Photo',
                        'initialPreview' => $model->isNewRecord ? [] : [
                            Html::img('@web/uploads/MIS_PATROL/' . $model->IMAGE_BEFORE_1, ['width' => '100%'])
                        ],
                    ],
                ])->label('Image Before');
                ?>

                
            </div>
            <div class="overlay" id="loading">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div class="panel-footer">
                <?php echo $form->errorSummary($model); ?>

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
        
        

        

        <?php ActiveForm::end(); ?>

    </div>

</div>

