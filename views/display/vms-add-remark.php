<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => null,
    'tab_title' => 'VMS Add Remark',
    'breadcrumbs_title' => 'VMS Add Remark'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 1.5em; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5; font-family: 'Open Sans', sans-serif;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .badge {font-weight: normal;}";
$this->registerCss($css_string);

date_default_timezone_set('Asia/Jakarta');


?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['vms-add-remark', 'vms_date' => $vms_date, 'item' => $item, 'plan_qty' => $plan_qty, 'act_qty' => $act_qty]),
]); ?>

<div style="margin: auto; max-width: 600px; padding-top: 50px;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Add Remark Form</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'vms_date')->textInput(['readonly' => 'readonly']); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'item')->textInput(['readonly' => 'readonly']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <?= $form->field($model, 'item_description')->textInput(['readonly' => 'readonly']); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'item_destination')->textInput(['readonly' => 'readonly'])->label('Destination'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'plan_qty')->textInput(['readonly' => 'readonly']); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'act_qty')->textInput(['readonly' => 'readonly']); ?>
                </div>
            </div>

            <?= $form->field($model, 'remark', [
                'inputOptions' => [
                    'autofocus' => 'autofocus',
                    'placeholder' => 'Input remark here...'
                ]
            ])->textInput(); ?>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'user_id', [
                        'inputOptions' => [
                            'onkeyup' => 'this.value=this.value.toUpperCase()',
                            'onfocusout' => 'this.value=this.value.toUpperCase()',
                            'placeholder' => 'Input NIK here...'
                        ],
                    ])->textInput()->label('Username'); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'password', [
                        'inputOptions' => [
                            'placeholder' => 'Use My HR Password...'
                        ]
                    ])->passwordInput(); ?>
                </div>
            </div>
            
        </div>
        <div class="panel-footer">
            <div class="form-group">
                <?= Html::submitButton('Add Remark', ['class' => 'btn btn-success btn-block']); ?>
            </div>
        </div>
    </div>
    
</div>

<?php ActiveForm::end(); ?>