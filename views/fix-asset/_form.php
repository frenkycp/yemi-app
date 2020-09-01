<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
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

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'asset_id')->textInput(['placeholder' => 'Enter fixed asset ID', 'readonly' => !$model->isNewRecord ? true : false]) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'jenis')->dropDownList(ArrayHelper::map(app\models\AssetTbl::find()
            ->select([
                'jenis'
            ])
            ->where([
                'FINANCE_ASSET' => 'Y'
            ])
            ->andWhere('jenis IS NOT NULL')
            ->groupBy('jenis')
            ->orderBy('jenis')
            ->all(), 'jenis', 'jenis'), [
                'prompt' => 'Select type or category'
            ])->label('Type') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'fixed_asst_account')->textInput() ?>
        </div>
        <div class="col-sm-5">
            <?= $form->field($model, 'computer_name')->textInput(['placeholder' => 'Enter description'])->label('Fix Asset Description') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($model, 'LOC')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\AssetLocTbl::find()
                    ->orderBy('LOC_TYPE, LOC_GROUP_DESC, LOC_DESC')
                    ->all(), 'LOC', 'fullDesc'),
                    'options' => [
                        'placeholder' => 'Choose location...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
            ])->label('Location'); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'nik')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\Karyawan::find()
                    ->where([
                        'AKTIF' => 'Y'
                    ])
                    ->andWhere('PATINDEX(\'YE%\', NIK_SUN_FISH) > 0')
                    ->all(), 'NIK_SUN_FISH', 'nikSunfishNama'),
                    'options' => [
                        'placeholder' => 'Choose PIC...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
            ])->label('PIC'); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'cost_centre')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\CostCenter::find()
                    ->orderBy('CC_GROUP, CC_DESC')
                    ->all(), 'CC_ID', 'deptSection'),
                    'options' => [
                        'placeholder' => 'Choose Cost Center...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'FINANCE_ASSET')->dropDownList([
                'Y' => 'Y',
                'N' => 'N',
            ]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList(\Yii::$app->params['fixed_asset_status']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'label')->dropDownList([
                'Y' => 'Y',
                'N' => 'N',
            ]) ?>
        </div>
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
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'qty')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'AtCost')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'NBV')->textInput() ?>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Fix Asset Image
            </h3>
        </div>
        <div class="panel-body">
            <?php
            $filename = $model->primary_picture . '.jpg';
            $path1 = \Yii::$app->basePath . '\\web\\uploads\\ASSET_IMG\\' . $filename;
            if (file_exists($path1)) {
                echo $form->field($model, 'upload_file_asset')->widget(\kartik\file\FileInput::className(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['jpg'],
                        //'showCaption' => false,
                        //'showRemove' => false,
                        //'showUpload' => false,
                        //'browseClass' => 'btn btn-primary btn-block',
                        //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        //'browseLabel' =>  ' Select Photo',
                        'initialPreview'=>[
                            Html::img('@web/uploads/ASSET_IMG/' . $filename, ['width' => '100%'])
                        ],
                        'initialPreviewConfig' => [
                            ['caption' => 'Fix Asset Image'],
                        ],
                        //'initialPreviewAsData'=>true,
                    ],
                ])->label(false);
            } else {
                echo $form->field($model, 'upload_file_asset')->widget(\kartik\file\FileInput::className(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['jpg'],
                        //'showCaption' => false,
                        //'showRemove' => false,
                        //'showUpload' => false,
                        //'browseClass' => 'btn btn-primary btn-block',
                        //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        //'browseLabel' =>  ' Select Photo',
                        // 'initialPreview'=>[
                        //     Html::img('@web/uploads/image-not-available.png', ['width' => '100%'])
                        // ],
                        // 'initialPreviewConfig' => [
                        //     ['caption' => 'No Image Found'],
                        // ],
                        //'initialPreviewAsData'=>true,
                    ],
                ])->label(false);
            }
            ?>
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
            &nbsp;&nbsp;
            <?=             Html::a(
            '<span class="fa fa-undo"></span> Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>
        

        <?php ActiveForm::end(); ?>

    </div>

</div>

