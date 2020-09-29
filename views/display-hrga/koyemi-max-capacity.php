<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    //'page_title' => 'Machine Utility Rank (Daily) <span class="japanesse text-green"></span>',
    'page_title' => 'Koyemi Max Capacity',
    'tab_title' => 'Koyemi Max Capacity',
    'breadcrumbs_title' => 'Koyemi Max Capacity'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');
$bg_url = Url::to('@web/uploads/ICON/coronavirus_03.png');

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    //body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    //body, .content-wrapper {background-image: url('" . $bg_url . "');}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .content {padding: 0px;}
    .table tr {border-collapse:separate; border-spacing:0 5px;}
    .table > tbody > tr > td {padding: 0px;}
    //tr:nth-child(even) {background-color: rgba(255, 255, 255, 0.15);}
    //tr:nth-child(odd) {background-color: rgba(255, 255, 255, 0.1);}
    marquee span { 
        margin-right: 100%; 
    } 
    marquee p { 
        white-space:nowrap;
        margin-right: 1000px; 
    } 
    #container-list {
        border: 1px solid gray;
        border-radius: 10px;
        padding: 5px 0px;
    }
    #img-title {
        border: 1px solid gray;
        border-radius: 10px;
        padding: 5px 0px;
    }
    #img-txt {
        font-size: 4em;
    }
    .badge {
        font-size: 2em;
        margin: 5px;
    }
    #total-pengunjung {
        font-size: 20em;
        font-family: sans-serif;
    }
    #detail-pengunjung {
        padding: 5px;
    }
    #list-pengunjung {
        padding-left: 20px;
        font-size: 1.2em;
    }
");

$script = "
    $(document).ready(function() {
        setupRefresh();
    });

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 3600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );
?>
<div class="row" style="background-color: #61258e;">
    <div class="col-md-12">
        <div class="text-center">
            <span id="today" style="color: white; font-size: 2em; font-weight: bold; letter-spacing: 2px; padding-left: 10px;">
                KOYEMI VISITOR
            </span>
        </div>
    </div>
</div>
<div class="row" style="margin: 10px;">
    <div class="col-sm-6 text-center">
        <div class="panel panel-primary">
            <div class="panel-heading" style="background-color: #61258e;">
                <h3 class="panel-title" style="font-size: 2em;">TOTAL PEMBELI</h3>
            </div>
            <div class="panel-body no-padding">
                <span id="total-pengunjung">3</span>
                <hr style="margin: 0px;">
                <div id="detail-pengunjung" class="text-left">
                    <span style="font-size: 1.5em;">
                        List Pembeli :
                    </span>
                    <div id="list-pengunjung">
                        <span id="pengunjung-1">-</span><br/>
                        <span id="pengunjung-2">-</span><br/>
                        <span id="pengunjung-3">-</span><br/>
                        <span id="pengunjung-4">-</span><br/>
                        <span id="pengunjung-5">-</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-6 text-center">
        <div id="img-title" class="bg-green">
            <span id="img-txt">"BOLEH MASUK"</span>
        </div>
        <div id="img" style="height: 600px;">
            <?= Html::img('@web/uploads/ICON/NO.png', [
                'height' => '100%'
            ]); ?>
        </div>
    </div>
</div>