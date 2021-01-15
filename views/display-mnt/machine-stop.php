<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;

$this->title = [
    'page_title' => '<span class="text-red"><i class="fa fa-warning"></i></span>&nbsp;&nbsp; MACHINE STOP &nbsp;&nbsp;<span class="text-red"><i class="fa fa-warning"></i></span>',
    'tab_title' => 'MACHINE STOP',
    'breadcrumbs_title' => 'MACHINE STOP'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 1.5em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .badge {font-weight: normal;}

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
        border-spacing: 25px;
        border-collapse: separate;
    }
    .summary-tbl > tbody > tr > td{
        font-size: 56px;
        background: #000;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.5px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 12px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: white !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: yellow;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #yesterday-tbl > tbody > tr > td{
        border:1px solid #777474;
        background: #000;
        color: #FFF;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 2px;
        //height: 100px;
    }
    #popup-tbl > tfoot > tr > td {
        font-weight: bold;
        background-color: rgba(0, 0, 150, 0.3);
    }
    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    #running-well {
        font-size: 100px;
        color: " . \Yii::$app->params['bg-green'] . ";
        font-weight: bold;
        letter-spacing: 3px;
        text-shadow: -1px -1px 0 #0F0
    }
    td {
        border-top: 1px solid white !important;
        border-bottom: 1px solid white !important;
    }
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

date_default_timezone_set('Asia/Jakarta');

$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['machine-stop-time']) . "',
            success: function(data){
                if(data.total_stop == 0){
                    if(!$('#running-well').length){
                        $('#tbody-id').html('<div id=\"running-well\"><marquee behavior=\"scroll\" scrollamount=\"20\">ALL ARE RUNNING WELL</marquee></div>');
                    }
                } else {
                    $('#tbody-id').html(data.tbody_content);
                }
                
                
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

/*echo '<pre>';
print_r($data_mttr);
echo '</pre>';*/

/*echo '<pre>';
print_r($data_new);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<table class="table summary-tbl">
    <tbody id="tbody-id">
        
    </tbody>
</table>