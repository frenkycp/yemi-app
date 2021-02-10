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
* @var app\models\LiveCookingRequest $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="live-cooking-request-form">

    <?php $form = ActiveForm::begin([
    'id' => 'LiveCookingRequest',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    ]
    );
    ?>
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <?= 
                    //$form->field($model, 'post_date')->textInput(['readonly' => true]);
                    $form->field($model, 'post_date')->widget(DatePicker::classname(), [
                        'options' => [
                            'type' => DatePicker::TYPE_INPUT,
                        ],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'cc')->dropDownList(ArrayHelper::map(app\models\LiveCookingList::find()->orderBy('cc_desc')->all(), 'cc', 'cc_desc'), [
                        'prompt' => 'Choose...'
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'employee')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\Karyawan::find()->select(['NIK', 'NIK_SUN_FISH', 'NAMA_KARYAWAN'])->orderBy('NAMA_KARYAWAN')->all(), 'NIK_SUN_FISH', 'nikSunfishNama'),
                        'options' => ['placeholder' => 'Select name ...'],
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
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Create' : 'Save'),
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

<div class="panel panel-info">
    <div class="panel-body"></div>
</div>