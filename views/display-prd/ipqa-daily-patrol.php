<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'IPQA Daily Patrol <span class="japanesse light-green"></span>',
    'tab_title' => 'IPQA Daily Patrol',
    'breadcrumbs_title' => 'IPQA Daily Patrol'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center; display: none;}
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
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 16px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
        letter-spacing: 2px;
        font-weight: normal;
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
    .panel-title {
        font-size: 30px;
    }
    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    .summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .bg-yellow-mod {background-color: yellow !important;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}
    .expired-um {
        font-size: 60px;
        font-weight: bold;
        border: 1px solid black;
    }
    #main-title {
        color: white;
        font-size: 40px;
        padding: 10px 0px;
    }
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div id="main-title"><u>IPQA Daily Patrol</u></div>
<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="text-center" style="min-width: 130px;">Date</th>
            <th class="text-center" style="min-width: 100px;">Status</th>
            <th class="" style="min-width: 150px;">Location</th>
            <th class="text-center" style="min-width: 100px;">Part No.</th>
            <th class="" style="min-width: 180px;">Description</th>
            <th class="">Problem</th>
            <th class="">Problem Description</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($data) > 0) {
            ?>
            <?php foreach ($data as $key => $value): 
                if ($value->status == 0) {
                    $status_txt = 'OPEN';
                } elseif ($value->status == 2) {
                    $status_txt = 'PENDING';
                } else {
                    $status_txt = '-';
                }
                ?>
                <tr>
                    <td class="text-center"><?= date('d M\' Y', strtotime($value->event_date)); ?></td>
                    <td class="text-center"><?= $status_txt; ?></td>
                    <td class=""><?= $value->child_analyst_desc; ?></td>
                    <td class="text-center"><?= $value->child; ?></td>
                    <td class=""><?= $value->child_desc; ?></td>
                    <td class=""><?= $value->problem; ?></td>
                    <td class=""><?= $value->description; ?></td>
                </tr>
            <?php endforeach ?>
        <?php } else {
            echo '<tr>
                <td colspan="7">There is no OPEN/PENDING IPQA Daily Patrol data...</td>
            </tr>';
        }
        ?>
        
    </tbody>
</table>