<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/**
* @var yii\web\View $this
* @var app\models\AssetTbl $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="asset-tbl-form">

    <?php $form = ActiveForm::begin([
    'id' => 'AssetTbl',
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
                <div class="col-sm-3">
                    <?= $form->field($model, 'asset_id')->textInput(['readonly' => true]); ?>
                </div>
                <div class="col-sm-9">
                    <?= $form->field($model, 'computer_name')->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'purchase_date')->widget(DatePicker::classname(), [
                        'options' => [
                            'type' => DatePicker::TYPE_INPUT,
                        ],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'jenis')->textInput(); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'LOC')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\AssetLocTbl::find()
                            ->orderBy('LOC_TYPE, LOC_GROUP_DESC, LOC_DESC')
                            ->all(), 'LOC', 'fullDesc'),
                            'options' => [
                                'placeholder' => 'Select Location',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'cost_centre')->dropDownList(ArrayHelper::map(app\models\CostCenter::find()->orderBy('CC_GROUP, CC_DESC')->all(), 'CC_ID', 'deptSection'))->label('Section') ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'nik')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\KARYAWAN::find()->select([
                            'NIK_SUN_FISH', 'NAMA_KARYAWAN'
                        ])
                        ->where([
                            'AKTIF' => 'Y',
                        ])
                        ->all(), 'NIK_SUN_FISH', 'nikSunFishNama'),
                        'options' => [
                            'placeholder' => '- SELECT -',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('PIC'); ?>
                </div>
            </div>

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
            ['class' => 'btn btn-default']) ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

