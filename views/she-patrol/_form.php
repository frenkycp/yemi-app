<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\models\AuditPatrolTbl;
use kartik\checkbox\CheckboxX;

/**
* @var yii\web\View $this
* @var app\models\AuditPatrolTbl $model
* @var yii\widgets\ActiveForm $form
*/

$tmp_patrol_category = \Yii::$app->params['she_patrol_category'];
//asort($tmp_patrol_category);
if ($model->LOC_DESC != '' && $model->LOC_DESC != null) {
    $tmp_patrol_loc = ArrayHelper::map(app\models\ShePatrolArea::find()->where(['NAME' => $model->LOC_DESC])->orderBy('DETAIL')->all(), 'ID', 'DETAIL');
} else {
    $tmp_patrol_loc = ArrayHelper::map(app\models\ShePatrolArea::find()->orderBy('DETAIL')->all(), 'ID', 'DETAIL');
}

$karyawan_dropdown = ArrayHelper::map(app\models\AuditPatrolPic::find()->orderBy('PIC_NAME')->all(), 'PIC_ID', 'PIC_NAME');

$this->registerJs("$(document).ready(function() {
    $('#loc_id').trigger('change');
    $('#loading').hide();
});");
?>

<?= Html::a('Change Area', ['set-area'], ['class' => 'btn btn-primary btn-sm']); ?>
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

    <div class="" style="margin-top: 5px;">
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
                    <div class="col-sm-3">
                        <?= $form->field($model, 'AUDITOR')->textInput(['readonly' => true]); ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'LOC_DESC')->textInput(['readonly' => true])->label('Area'); ?>
                    </div>
                    <div class="col-sm-3">
                        <?= $form->field($model, 'LOC_ID')->dropDownList($tmp_patrol_loc, [
                            'id' => 'loc_id',
                            'onchange' => '
                                var loc_id = $(this).val();
                                $("#loading").show();
                                $.post( "' . Yii::$app->urlManager->createUrl('ajax-repository/she-patrol-loc?ID=') . '"+loc_id, function(data) {
                                    $("#loc_detail").val(data.loc_name);
                                });
                                $("#loading").hide();
                            ',
                        ])->label('Location'); ?>
                        
                        <?= $form->field($model, 'LOC_DETAIL')->hiddenInput(['id' => 'loc_detail'])->label(false) ?>
                    </div>
                    <!-- <div class="col-sm-6">
                        <?=  ''; /*$form->field($model, 'TOPIC')->dropDownList($tmp_patrol_category)->label('Potential Hazard');*/ ?>
                    </div> -->
                </div>



                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    Classification
                                </h3>
                            </div>
                            <div class="panel-body" style="padding-bottom: 0px;">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= $form->field($model, 'UNSAFE_CONDITION')->dropDownList([
                                            0 => 'N',
                                            1 => 'Y'
                                        ]);/*$form->field($model, 'UNSAFE_CONDITION')->widget(CheckboxX::classname(), [
                                            'pluginOptions' => [
                                                'threeState' => false
                                            ],
                                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                            'autoLabel' => true,
                                            'labelSettings' => [
                                                'label' => 'Unsafe Condition',
                                                'position' => CheckboxX::LABEL_LEFT
                                            ]
                                        ])->label(false);*/ ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'UNSAFE_ACTION')->dropDownList([
                                            0 => 'N',
                                            1 => 'Y'
                                        ]);/*$form->field($model, 'UNSAFE_ACTION')->widget(CheckboxX::classname(), [
                                            'pluginOptions' => [
                                                'threeState' => false
                                            ],
                                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                            'autoLabel' => true,
                                            'labelSettings' => [
                                                'label' => 'Unsafe Action',
                                                'position' => CheckboxX::LABEL_LEFT
                                            ],
                                        ])->label(false);*/ ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'HOUSEKEEPING')->dropDownList([
                                            0 => 'N',
                                            1 => 'Y'
                                        ])->label('5S/Housekeeping');/*$form->field($model, 'HOUSEKEEPING')->widget(CheckboxX::classname(), [
                                            'pluginOptions' => [
                                                'threeState' => false
                                            ],
                                            'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                            'autoLabel' => true,
                                            'labelSettings' => [
                                                'label' => '5S/Housekeeping',
                                                'position' => CheckboxX::LABEL_LEFT
                                            ],
                                        ])->label(false);*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
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
                            Html::img('@web/uploads/SHE_PATROL/' . $model->IMAGE_BEFORE_1, ['height' => '100%'])
                        ],
                    ],
                ])->label('Image Before');
                ?>

                <?= $form->field($model, 'DESCRIPTION')->textInput() ?>
            </div>
            <div class="overlay" id="loading" style="display: none;">
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
                    'All Data',
                    \yii\helpers\Url::to(['she-patrol/index']),
                    ['class' => 'btn btn-warning']) ?>
            </div>
        </div>
        
        

        

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php
$todays_data = AuditPatrolTbl::find()
->where([
    'CATEGORY' => 4,
    'LOC_DESC' => $model->LOC_DESC,
    'PATROL_DATE' => $model->PATROL_DATE
])
->orderBy('PATROL_DATETIME DESC')
->all();
?>


<div class="panel panel-primary">
    <div class="panel-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Potential Hazard</th>
                    <th>Location</th>
                    <th>PIC</th>
                    <th>Description</th>
                    <th>Patrol Datetime</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($todays_data) > 0) { ?>
                    <?php foreach ($todays_data as $key => $value): ?>
                        <tr>
                            <td><?= $value->TOPIC; ?></td>
                            <td><?= $value->LOC_DETAIL; ?></td>
                            <td><?= $value->PIC_NAME; ?></td>
                            <td><?= $value->DESCRIPTION; ?></td>
                            <td><?= $value->PATROL_DATETIME; ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
</div>