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
    'page_title' => 'QC KPI TODAY',
    'tab_title' => 'QC KPI TODAY',
    'breadcrumbs_title' => 'QC KPI TODAY'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 1em; text-align: center;}
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
        height: 100%;
    }
    .summary-tbl > tbody > tr > td{
        border:2px solid grey;
        font-size: 40px;
        background: #000;
        color: #FFF;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 1.5px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 40px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
        padding: 0px 10px;
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
        font-size: 50px;
        background: #000;
        color: white;
        vertical-align: middle;
        padding: 10px 10px;
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
    //td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    .sortir-class {
        font-family: Impact, Charcoal, sans-serif !important;
        font-size: 70px !important;
        letter-spacing: 5px !important;
        height: 100px !important;
    }
    .table-list div{
        min-height: 130px;
    }
    .ok-style {
        font-family: Impact, Charcoal, sans-serif !important;
        font-size: 140px !important;
    }
    .row-title {
        font-family: Impact, Charcoal, sans-serif !important;
        font-size: 150px !important;
        line-height: 50% !important;
        height: 315px;
        padding-top: 50px !important;
        //padding-top: 40px !important;
    }
    .sortir-small {
        font-size: 0.3em;
        font-family: sans-serif;
        letter-spacing: 2px;
        
    }
    marquee span { 
        margin-right: 100%px;
    } 
    marquee p { 
        white-space:nowrap;
        margin-right: 100px; 
    } 
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    $(document).ready(function() {
        var i = 0;
        setInterval(function() {
            i++;
            if(i%2 == 0){
                $(".blink").css("background-color", "red");
                $(".blink").css("color", "white");
            } else {
                $(".blink").css("background-color", "white");
                $(".blink").css("color", "red");
            }
        }, 700);
    });
JS;
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data_mttr);
echo '</pre>';*/

/*echo '<pre>';
print_r($data_new);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<table class="table summary-tbl" style="margin-top: 10px;">
    <tbody>
        <?php 
        if ($data1) { ?>
            <tr>
                <td class="text-center row-title" rowspan="2" style="" width="600px">
                    IQC<br/>
                    <span class="sortir-small">( Lotout/Sortir )</span>
                </td>
                <td class="text-center sortir-class blink">
                    LOTOUT / SORTIR
                </td>
            </tr>

            <tr>
                <td class="table-list text-center">
                    <div class="col-sm-12">
                        <?= $data1->ITEM . ' - ' . $data1->ITEM_DESC . '<br/>(' . $data1->QTY_IN . ' pcs)'; ?>
                    </div>
                </td>
            </tr>
        <?php } else { ?>
            <tr>
                <td class="text-center row-title" style="" width="600px">
                    IQC<br/>
                    <span class="sortir-small">( Lotout/Sortir )</span>
                </td>
                <td class="text-center ok-style">
                    OK
                </td>
            </tr>
        <?php }
        ?>
        
        

        <?php 
        if ($data2_total <= 10) { ?>
            <tr>
                <td class="text-center row-title" style="">
                    IPQA<br/>
                    <span class="sortir-small">( Open > 10 <i class="fa fa-arrow-right"></i> <b><u>NG</u></b> )</span>
                </td>
                <td class="table-list">
                    <div>
                        <marquee scrollamount="20" behavior="scroll" style="background-color: transparent; color: white; font-weight: normal; clear: both; z-index:200; font-size: 1.5em;">
                            <?= $data2_marquee; ?>
                        </marquee>
                    </div>
                </td>
            </tr>
        <?php } else { ?>
            <tr>
                <td class="text-center row-title" rowspan="2" style="">
                    IPQA<br/>
                    <span class="sortir-small">( Open > 10 <i class="fa fa-arrow-right"></i> <b><u>NG</u></b> )</span>
                </td>
                <td class="text-center sortir-class blink">
                    <b><?= $data2_total; ?></b> <small>OPEN</small>
                </td>
            </tr>
            <tr>
                <td class="table-list text-center">
                    <div>
                        <marquee scrollamount="20" behavior="scroll" style="background-color: transparent; color: white; font-weight: normal; clear: both; z-index:200; font-size: 1.5em;">
                            <?= $data2_marquee; ?>
                        </marquee>
                    </div>
                </td>
            </tr>
        <?php }
        ?>
        
        <?php 
        if ($data3->gmc == null) { ?>
            <tr>
                <td class="text-center row-title" style="">
                    FQC<br/>
                    <span class="sortir-small">( Lotout/Repair )</span>
                </td>
                <td class="text-center ok-style">
                    OK
                </td>
            </tr>
        <?php } else { ?>
            <tr>
                <td class="text-center row-title" rowspan="2" style="">
                    FQC<br/>
                    <span class="sortir-small">( Lotout/Repair )</span>
                </td>
                <td class="text-center sortir-class blink">
                    LOTOUT / REPAIR
                </td>
            </tr>
            <tr>
                <td class="table-list text-center">
                    <div class="col-sm-12">
                        <?= $data3->gmc . ' - ' . $data3->description . '<br/>(' . $data3->total_ng . ' set) <i class="fa fa-arrow-right"></i> <b>' . $data3->status . '</b>'; ?>
                    </div>
                </td>
            </tr>
        <?php }
        ?>
        
    </tbody>
</table>