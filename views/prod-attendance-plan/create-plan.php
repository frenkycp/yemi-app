<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Create MP Plan <span class="japanesse text-green"></span>',
    'tab_title' => 'Create MP Plan',
    'breadcrumbs_title' => 'Create MP Plan'
];

$this->registerCss("
    .form-group {
        margin-bottom: 0px;
    }
");

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
                <div class="col-md-4">
                    <?= $form->field($model, 'location')->dropDownList($location_arr, [
                        'prompt' => 'Choose location...'
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <?php echo '<label class="control-label">Select date range</label>';
                    echo DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'from_date',
                        'attribute2' => 'to_date',
                        'options' => ['placeholder' => 'Start date'],
                        'options2' => ['placeholder' => 'End date'],
                        'type' => DatePicker::TYPE_RANGE,
                        'form' => $form,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ]
                    ]);?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'shift')->dropDownList([
                        1 => 1,
                        2 => 2,
                        3 => 3,
                    ], [
                        'prompt' => 'Choose location...'
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'manpower')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\Karyawan::find()->select(['NIK_SUN_FISH', 'NAMA_KARYAWAN'])->where([
                        'AKTIF' => 'Y',
                        'DEPARTEMEN' => 'PRODUCTION'
                    ])->andWhere('NIK_SUN_FISH IS NOT NULL')->orderBy('NAMA_KARYAWAN')->all(), 'nikSunfishNama', 'nikSunfishNama'),
                    'options' => ['placeholder' => 'Select manpower ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true
                    ],
                ]); ?>
                </div>
            </div>
            

            <?php echo $form->errorSummary($model); ?>
        </div>
        <div class="panel-footer">
            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> Create',
            [
            'id' => 'btn-submit',
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

