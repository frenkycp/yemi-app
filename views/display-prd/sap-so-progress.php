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
    'page_title' => 'SCM ORDER vs EXPORT <span class="japanesse light-green">(SCM受注 対出荷)</span>',
    'tab_title' => 'SCM ORDER vs EXPORT',
    'breadcrumbs_title' => 'SCM ORDER vs EXPORT'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 18px; text-align: center;}
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
        font-size: 50px;
        background: #33383d;
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
    .progress-text{
        color: black;
        font-size: 50px;
        letter-spacing: 1px;
    }
    .progress-number {
        color: black;
        font-size: 50px;
        letter-spacing: 1px;
        font-weight: bold;
    }
    .progress-bar {
        font-size: 150px;
        line-height: 250px;
        -webkit-text-stroke: 2px grey;
    }
    .progress {
        height: 250px;
        font-family: Impact, Charcoal, sans-serif !important;
        letter-spacing: 5px;
        outline: 1px solid silver;
    }
    .progress-group {
        padding-top: 50px;
    }
    .panel-title {
        font-size: 60px;
        font-weight: bold;
    }
    .progress-bar-success {
        background-color: green;
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
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

/*$script = "
    $('document').ready(function() {
        $('#popup-tbl').DataTable({
            'order': [[ 6, 'desc' ]]
        });
    });
";
$this->registerJs($script, View::POS_HEAD );*/

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_top_minus);
echo '</pre>';*/
?>
<br/>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center"><?= strtoupper($last_month_data['period']); ?></h3>
            </div>
            <div class="panel-body">
                <div class="progress-group">
                    <span class="progress-text">SCM Order (SCM<span class="japanesse">受注</span>)</span>
                    <span class="progress-number"></span>

                    <div class="progress">
                        <div class="progress-bar progress-bar-success" style="width: 100%">100%</div>
                    </div>
                </div>

                <div class="progress-group" style="display: none;">
                    <span class="progress-text">OUTPUT (FLO)</span>
                    <span class="progress-number">
                        <?= number_format($last_month_data['output']); ?>
                        <small>(<?= $last_month_data['output_pct']; ?>%)</small>
                    </span>

                    <div class="progress">
                        <div class="progress-bar progress-bar-primary progress-bar-striped active" style="width: <?= $last_month_data['output_pct'] ?>%"></div>
                    </div>
                </div>

                <div class="progress-group">
                    <span class="progress-text">EXPORT (<span class="japanesse">出荷</span>)</span>
                    <span class="progress-number"></span>

                    <div class="progress">
                        <div class="progress-bar progress-bar-primary progress-bar-striped active" style="width: <?= $last_month_data['export_pct']; ?>%"><?= $last_month_data['export_pct']; ?>%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center"><?= strtoupper($this_month_data['period']); ?></h3>
            </div>
            <div class="panel-body">
                <div class="progress-group">
                    <span class="progress-text">SCM Order (SCM<span class="japanesse">受注</span>)</span>
                    <span class="progress-number"></span>

                    <div class="progress">
                        <div class="progress-bar progress-bar-success" style="width: 100%">100%</div>
                    </div>
                </div>

                <div class="progress-group" style="display: none;">
                    <span class="progress-text">OUTPUT (FLO)</span>
                    <span class="progress-number">
                        <?= number_format($this_month_data['output']); ?>
                        <small>(<?= $this_month_data['output_pct']; ?>%)</small>
                    </span>

                    <div class="progress">
                        <div class="progress-bar progress-bar-primary progress-bar-striped active" style="width: <?= $this_month_data['output_pct'] ?>%"></div>
                    </div>
                </div>

                <div class="progress-group">
                    <span class="progress-text">EXPORT (<span class="japanesse">出荷</span>)</span>
                    <span class="progress-number"></span>

                    <div class="progress">
                        <div class="progress-bar progress-bar-primary progress-bar-striped active" style="width: <?= $this_month_data['export_pct']; ?>%"><?= $this_month_data['export_pct']; ?>%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>