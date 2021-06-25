<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
	    'page_title' => 'SHE Patrol Action <span class="japanesse light-green"></span>',
	    'tab_title' => 'SHE Patrol Action',
	    'breadcrumbs_title' => 'SHE Patrol Action'
	];

?>

<?php $form = ActiveForm::begin([
	'id' => 'AssetTbl',
	//'layout' => 'horizontal',
	'enableClientValidation' => true,
	'errorSummaryCssClass' => 'error-summary alert alert-danger',
]
);
?>

<div class="panel panel-primary">
	<div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
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
                                ], [
                                    'disabled' => true,
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
                                ], [
                                    'disabled' => true,
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
                                ], [
                                    'disabled' => true,
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
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'LOC_DESC')->textInput(['readonly' => true])->label('Area'); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'LOC_DETAIL')->textInput(['readonly' => true])->label('Location'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'DESCRIPTION')->textInput(['readonly' => true]); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($custom_model, 'ACTION')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
		<?php
        echo $form->field($custom_model, 'upload_after_1')->widget(\kartik\file\FileInput::className(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  ' Select Photo',
                'initialPreview' => $model->IMAGE_AFTER_1 == null ? [] : [
                    Html::img('@web/uploads/SHE_PATROL/' . $model->IMAGE_AFTER_1, ['width' => '100%'])
                ],
            ],
        ])->label('Image After');
        ?>
	</div>
	<div class="panel-footer">

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> Submit',
        [
        'id' => 'save-' . $custom_model->formName(),
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