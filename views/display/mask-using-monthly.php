<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Masker Using (This Month)',
    'tab_title' => 'Masker Using (This Month)',
    'breadcrumbs_title' => 'Masker Using (This Month)'
];

//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; text-align: center;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .form-horizontal .control-label {padding-top: 0px;}
    #myTable {font-size: 1.3em; letter-spacing: 1px; color: white;}
    #myTable > tbody > tr:nth-child(odd) > td {background-color: #2f2f2f; color: white;}
    #myTable > tbody > tr:nth-child(even) > td {background-color: #121213; color: white;}
    #myTable > thead > tr > th {background-color: #61258e; color: #ffeb3b;}
    .dataTables_wrapper {color: white;}
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 1800000); // milliseconds
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
    $('#myTable').DataTable({
        'pageLength': 25,
        'order': [[ 3, 'desc' ], [ 1, 'asc' ]]
    });
});");

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div class="panel panel-default" style="background-color: black;">
    <div class="panel-body">
        <table id="myTable" class="table">
            <thead>
                <tr>
                    <th class="text-center">NIK</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th class="text-center">Total Qty</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $value): ?>
                    <tr style="font-size: 0.84em;">
                        <td class="text-center"><?= $value->nik; ?></td>
                        <td><?= $value->nama; ?></td>
                        <td><?= $value->dept; ?></td>
                        <td class="text-center"><?= $value->qty; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>