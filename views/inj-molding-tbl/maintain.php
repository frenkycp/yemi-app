<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Molding Maintenance <span class="japanesse light-green"></span>',
    'tab_title' => 'Molding Maintenance',
    'breadcrumbs_title' => 'Molding Maintenance'
];

$css_string = "
    #total_time {font-size: 30px;}";
$this->registerCss($css_string);
?>

<?php $form = ActiveForm::begin([
	'id' => 'AssetTbl',
	//'layout' => 'horizontal',
	'enableClientValidation' => true,
	'errorSummaryCssClass' => 'error-summary alert alert-danger',
]
);
?>

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-body">
                <?= $form->field($model, 'MOLDING_ID')->textInput(['readonly' => true]) ?>
                <?= $form->field($model, 'MOLDING_NAME')->textInput(['readonly' => true]) ?>
                <?= $form->field($model, 'NOTE')->textInput(['placeholder' => 'Insert remark here...']) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title">
                    <span id="total_time">
                        00 h : 00 m : 00 s
                    </span>
                </h3>
            </div>
            <div class="panel-body">
                <?= Html::a('PAUSE', '#', ['class' => 'btn btn-warning btn-block', 'style' => 'font-size: 30px;']); ?>

                <?= Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> FINISH',
                [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success btn-block',
                'style' => 'font-size: 30px;'
                ]
                );
                ?>
            </div>
        </div>
        
    </div>
</div>
		

<?php ActiveForm::end(); ?>