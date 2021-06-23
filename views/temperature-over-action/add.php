<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

$this->title = [
    'page_title' => 'Temperature Over Add Action <span class="japanesse light-green"></span>',
    'tab_title' => 'Temperature Over Add Action',
    'breadcrumbs_title' => 'Temperature Over Add Action'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$css_string = "
    //.form-control, .control-label {background-color: #FFF; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #FFF;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: white;
        color: black;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #777474 !important;
        background-color: rgb(255, 229, 153);
        color: black;
        font-size: 16px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: black !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: white;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .column-1 {width: 40%;}
    .column-2 {width: 30%;}
    .column-3 {width: 30%;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //#summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);
?>

<div class="temperature-over-action-form">

    <?php $form = ActiveForm::begin([
    'id' => 'TemperatureOverAction',
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

<div style="margin: auto; width: 600px; padding-top: 20px;" id="display-container">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Temperature Over Add Action</h3>
        </div>
        <div class="panel-body">
            <?= $form->field($model, 'ID')->textInput(['maxlength' => true, 'readonly' => true]) ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'POST_DATE')->textInput(['readonly' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'LAST_CHECK')->textInput(['readonly' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'EMP_ID')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'EMP_NAME')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'SHIFT')->textInput(['readonly' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'OLD_TEMPERATURE')->textInput(['readonly' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'NEW_TEMPERATURE')->textInput()->label('New Temperature <span class="text-red">*</span>') ?>
                </div>
            </div>
            
            <?= $form->field($model, 'NEXT_ACTION')->dropDownList([
                1 => 'KEMBALI BEKERJA',
                2 => 'DIPULANGKAN',
            ])->label('Action <span class="text-red">*</span>') ?>
            <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> SUBMIT',
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success btn-block'
            ]
            );
            ?>
            <?php echo $form->errorSummary($model); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>