<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    'page_title' => null,
    'tab_title' => 'Break Time',
    'breadcrumbs_title' => 'Break Time'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center; padding: 0px !important;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    //body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        //width: 50%;
    }
    #break-time {
        color: white;
        font-size: 3em;
    }
    .toilet-container {border: 1px solid white; border-radius: 20px;}
    .toilet-text {font-size: 3em; padding: 0px 25px; background-color: rgba(0, 0, 0, 0.8); border-radius: 25px; letter-spacing: 5px;}
    .stopwatch-container {border-radius: 5px; margin: 0px 20px; font-size: 11em; color: white; letter-spacing: 3px;}
    #marquee-container {color: #333333; font-size: 5.5em; margin-top: 0.5em; font-weight: bold; letter-spacing: 7px; position: fixed;
                z-index:2;
                right: 0;
                bottom: 0;
                left: 0;
                padding: 0.4% 0% 0.5% 0%;
                text-align: center;
                clear: both;
}
");

$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['break-time-data']) . "',
            success: function(data){
                $('#server-time').html(data.server_time);
                $('#start-time').html(data.start_time);
                $('#end-time').html(data.end_time);
                $('#count-down').html(data.countdown);
            },
            complete: function(){
                setTimeout(function(){update_data();}, 500);
            }
        });
    }
    $(document).ready(function() {
        update_data();
    });
");

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
?>
<div id="break-time">
    <ul>
        <li>Server Time : <span id="server-time"></span></li>
        <li>Break Time (Start) : <span id="start-time"></span></li>
        <li>Break Time (End) : <span id="end-time"></span></li>
        <li>Count Down : <span id="count-down"></span></li>
    </ul>
</div>