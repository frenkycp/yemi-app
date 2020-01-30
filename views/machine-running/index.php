<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'Dashboard <span class="japanesse text-green"></span>',
    'tab_title' => 'Dashboard',
    'breadcrumbs_title' => 'Dashboard'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; text-align: center;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .btn-lg {font-size: 3em;}

    #progress-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #progress-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #595F66;
        color: white;
        font-size: 20px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #progress-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
    }
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );


/*echo '<pre>';
print_r($current_data);
echo '</pre>';
echo $data['name'];*/
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right" style="color: white;">
            User : <?= $mcr_name; ?>
        </div>
    </div>
    <div class="col-md-12" style="padding-top: 5px;">
        <div class="pull-right">
            <?= Html::a('Log Out', ['logout'], [
                'class' => 'btn btn-danger'
            ]) ?>
        </div>
    </div>
    
</div>
<hr>

<div class="row">
    <div class="col-md-4">
        <?= Html::a('Wood Working', ['index-current', 'loc_id' => 'WW02'], [
            'class' => 'btn btn-primary btn-lg btn-block',
        ]); ?>
    </div>
    <div class="col-md-4">
        <?= Html::a('SPU', ['index-current', 'loc_id' => 'WU01'], [
            'class' => 'btn btn-primary btn-lg btn-block',
        ]); ?>
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary btn-lg btn-block disabled">PAINTING</button>
    </div>
</div>