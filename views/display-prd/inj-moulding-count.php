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
    'page_title' => 'Injection Moulding Count',
    'tab_title' => 'Injection Moulding Count',
    'breadcrumbs_title' => 'Injection Moulding Count'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    //.form-control, .control-label {background-color: #FFF; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
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
        font-size: 20px;
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
        font-size: 26px;
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
    .panel-title {
        font-size: 26px;
    }
    .moulding-name {
        font-size: 20px;
    }
    .current-count {
        font-size: 50px;
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

$script = "
    function refreshPage() {
       window.location = location.href;
    }
    window.onload = setupRefresh;
    var chart;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }

    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['inj-moulding-count-data']) . "',
            success: function(data){
                var tmp_text = '';
                $.each(data, function(index, data_val) {
                    $('#moulding-' + index).html(data_val.MOULDING_NAME);
                    $('#count-' + index).html(data_val.TOTAL_COUNT);
                    $('#update-' + index).html(data_val.LAST_UPDATE);
                });
            },
            complete: function(){
                setTimeout(function(){update_data();}, 2000);
            }
        });
    }

    $(document).ready(function() {
        update_data();
    });
";
$this->registerJs($script, View::POS_HEAD );

// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_data_arr);
echo '</pre>';*/
?>
<br/>
<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="text-center">Action</th>
            <th class="text-center">Machine ID</th>
            <th class="">Machine Name</th>
            <th class="">Current Moulding</th>
            <th class="text-center">Count</th>
            <th class="text-center">Last Count</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $key => $value): ?>
            <tr>
                <td class="text-center">
                    <i class="fa fa-pencil disable" title="Change Moulding"></i> 
                    <i class="fa fa-refresh disable" title="Reset Count"></i>
                </td>
                <td class="text-center"><?= $key; ?></td>
                <td class=""><?= $value['machine']; ?></td>
                <td class="">
                    <span id="moulding-<?= $key; ?>"><?= $value['moulding_name']; ?></span>
                </td>
                <td class="text-center">
                    <span id="count-<?= $key; ?>"><?= number_format($value['current_count']); ?></span>
                </td>
                <td class="text-center">
                    <span id="update-<?= $key; ?>">
                    <?= $value['last_update'] == '-' ? '-' : date('d M Y H:i', strtotime($value['last_update'])); ?>
                    </span>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div class="row" style="display: none;">
    <?php foreach ($data as $key => $value): ?>
        <div class="col-sm-4">
            <div class="panel panel-success">
                <div class="panel-heading text-center">
                    <h3 class="panel-title"><?= $value['machine']; ?></h3>
                </div>
                <div class="panel-body">
                    <div class="text-center moulding-name">
                        <b><?= $value['moulding_name']; ?></b>
                    </div>
                    <hr style="margin-bottom: 0px;">
                    <div class="text-center current-count">
                        <?= number_format($value['current_count']); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>