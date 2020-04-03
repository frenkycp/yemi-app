<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Mask Stock & Using',
    'tab_title' => 'Mask Stock & Using',
    'breadcrumbs_title' => 'Mask Stock & Using'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center; font-size: 0.5em; display: none;}
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
    .panel-body {background-color: black;}

    .table {font-size: 1em; letter-spacing: 1px; color: white;}
    .table > tbody > tr:nth-child(odd) > td {background-color: #2f2f2f; color: white;}
    .table > tbody > tr:nth-child(even) > td {background-color: #121213; color: white;}
    .table > thead > tr > th {background-color: #61258e; color: #ffeb3b;}
    .dataTables_wrapper {color: white;}
    td {border-top: unset !important;}
");

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
$this->registerJs($script, View::POS_HEAD );

$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#table-out').DataTable({
        'pageLength': 25,
        'order': [[ 0, 'desc' ]]
    });
});");

/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div class="pull-left" id="my-header">
    <span style="font-size: 2.5em; color: white;"><u>MASK STOCK & USING</u></span><br/>
    <span style="font-size: 1em; color: grey;">Last Update : <?= date('Y-m-d H:i:s'); ?>
</div>
<div class="row" style="margin: 20px;">
    <div class="col-md-12 text-center">
        <span style="color: white; font-size: 3em; border: 1px solid white; border-radius: 5px; padding: 10px;">Stock : <span style="color: yellow;"><?= number_format($stock); ?></span><br/></span></span>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">USING</h3>
            </div>
            <div class="panel-body">
                <table class="table" id="table-out">
                    <thead>
                        <tr>
                            <th class="text-center">Time</th>
                            <th class="text-center">NIK</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Reason</th>
                            <th class="text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($masker_out as $key => $value): ?>
                            <tr>
                                <td class="text-center"><?= $value->datetime; ?></td>
                                <td class="text-center"><?= $value->nik; ?></td>
                                <td><?= $value->nama; ?></td>
                                <td><?= $value->dept; ?></td>
                                <td><?= $value->keperluan; ?></td>
                                <td class="text-center"><?= $value->qty; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>