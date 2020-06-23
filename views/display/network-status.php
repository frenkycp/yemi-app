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
    'page_title' => 'Network Status',
    'tab_title' => 'Network Status',
    'breadcrumbs_title' => 'Network Status'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCssFile('@web/css/component.css');
$this->registerJsFile('@web/js/snap.svg-min.js');
$this->registerJsFile('@web/js/classie.js');
$this->registerJsFile('@web/js/svgLoader.js');

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .form-horizontal .control-label {padding-top: 0px;}
    .myTable {font-size: 1em; color: white; letter-spacing: 1px;}
    //.myTable > tbody > tr:nth-child(odd) > td {background-color: #2f2f2f; color: white;}
    //.myTable > tbody > tr:nth-child(even) > td {background-color: #121213; color: white;}
    .myTable > thead > tr > th {background-color: #61258e; color: #ffeb3b;}
    .myTable > tbody > tr > td {font-size: 0.8em;}
    .dataTables_wrapper {color: white;}
    .table-title {font-size: 1.5em;}
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 5000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#myTable').DataTable({
        'pageLength': 15,
        'order': [[ 0, 'desc' ]]
    });
});");*/

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div style="height: 97vh;">
    <div class="row" style="height: 100%; border: 1px solid grey;">
        <div class="col-md-7" style="height: 100%; text-align: center; vertical-align: middle;">
            <span style="color: white; font-size: <?= $no == 1 ? '50vh' : '20vh'; ?>; line-height: 97vh;"><?= $title; ?></span>
        </div>
        <div class="col-md-5 text-center" style="height: 100%; padding: 0px;">
            <div class="<?= $bg_class; ?>" style="height: 50%; color: white; border-width: 0px 0px 1px 1px; border-style: solid; border-color: grey;">
                <span style="line-height: 48vh; font-size: 15em;"><?= $speed_mbps; ?> <span style="font-size: 0.5em;">Mbps</span></span>
            </div>
            <div style="height: 50%; color: white; border-width: 0px 0px 0px 1px; border-style: solid; border-color: grey;">
                <span style="line-height: 48vh; font-size: 20em;"><?= $info; ?></span>
            </div>
        </div>
    </div>
</div>