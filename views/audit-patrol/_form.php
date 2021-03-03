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
        <div class="panel panel-primary">
            <div class="panel-body">
                <?= $form->field($model, 'PATROL_DATE')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter date ...'],
                    'pluginOptions' => [
                        'autoclose'=>true
                    ]
                ]) ?>

                <?= $form->field($model, 'AUDITOR')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'CATEGORY')->dropDownList(\Yii::$app->params['audit_patrol_category'])->label('Patrol Type'); ?>

                <?= $form->field($model, 'TOPIC')->dropDownList(\Yii::$app->params['audit_patrol_topic'])->label('Patrol Category'); ?>

                <?= $form->field($model, 'LOC_ID')->dropDownList(\Yii::$app->params['wip_location_arr'])->label('Location'); ?>

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
                            Html::img('@web/uploads/AUDIT_PATROL/' . $model->IMAGE_BEFORE_1, ['width' => '100%'])
                        ],
                    ],
                ])->label('Image Before');
                ?>

                <?= $form->field($model, 'DESCRIPTION')->textInput() ?>

                <?= $form->field($model, 'PIC_ID')->widget(Select2::classname(), [
                    'data' => $karyawan_dropdown,
                    'options' => [
                        'placeholder' => '- SELECT PIC -',
                        'id' => 'repair-pic-' . $i,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label('PIC'); ?>
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

