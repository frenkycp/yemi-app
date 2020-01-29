<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Abnormal LT control <span class="japanesse light-green">リードタイム異常管理</span>',
    'tab_title' => 'Abnormal LT control ',
    'breadcrumbs_title' => 'Abnormal LT control ',
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .control-label {color: white;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .clinic-container {border: 1px solid white; border-radius: 10px; padding: 5px 20px;}

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        font-size: 4em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        height: 120px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important; font-weight: bold !important;}
    .description {font-size: 2.2em; padding-left: 10px;}
    .text-red{color: #ff1c00 !important;}
");


date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 30000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    window.setInterval(function(){
        $('.blinked').toggle();
    },600);
";
$this->registerJs($script, View::POS_HEAD );

?>

<span style="color: white">Last Update : <?= date('Y-m-d H:i'); ?></span>
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th></th>
            <th class="text-center" width="25%">LT ≤ 24H</th>
            <th class="text-center" width="25%">LT > 24H</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="">L - Series</td>
            <td class="text-center actual"><?= number_format($data['l1']); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $data['l2'] > 0 ? ' text-red' : ' text-green'; ?>"><?= number_format($data['l2']); ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
        <tr>
            <td style="">HS - Series</td>
            <td class="text-center actual"><?= number_format($data['hs1']); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $data['hs2'] > 0 ? ' text-red' : ' text-green'; ?>"><?= number_format($data['hs2']); ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
        <tr>
            <td style="">P40 - Series</td>
            <td class="text-center actual"><?= number_format($data['p40_1']); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $data['p40_2'] > 0 ? ' text-red' : ' text-green'; ?>"><?= number_format($data['p40_2']); ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
    </tbody>
</table>

<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th></th>
            <th class="text-center" width="25%">LT ≤ 36H</th>
            <th class="text-center" width="25%">LT > 36H</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="">XXX - Series</td>
            <td class="text-center actual"><?= number_format($data['xxx_1']); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $data['xxx_2'] > 0 ? ' text-red' : ' text-green'; ?>"><?= number_format($data['xxx_2']); ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
    </tbody>
</table>