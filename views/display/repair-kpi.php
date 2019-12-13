<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'PCB repair status <span class="japanesse light-green">基板修理の管理表</span>',
    'tab_title' => 'PCB repair status ',
    'breadcrumbs_title' => 'PCB repair status ',
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .control-label {color: white;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center;}
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
    .clinic-container {border: 1px solid white; border-radius: 10px; padding: 5px 20px;}

    #detail-tbl{
        border:1px solid #ddd;
        border-top: 0;
    }
    #detail-tbl > thead > tr > th{
        font-weight: normal;
        border:1px solid #8b8c8d;
        background-color: #858689;
        color: white;
        font-size: 2em;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #detail-tbl > tbody > tr > td{
        border:1px solid #ddd;
        font-size: 1.5em;
        background-color: #000;
        //font-weight: 1000;
        color: rgba(255, 235, 59, 1);
        vertical-align: middle;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important; font-weight: bold !important;}
    .description {font-size: 2.2em; padding-left: 10px;}
    .text-red{color: #ff1c00 !important;}
    .small-box {background-color: #dd4b3900 !important; border: 1px solid white; font-family: Impact, Charcoal, sans-serif !important;}
    .small-box>.inner {padding: 0px;}
");


date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    window.setInterval(function(){
        $('.blinked').toggle();
    },600);
";
$this->registerJs($script, View::POS_HEAD );


?>
<span style="color: white; font-size: 1.5em;">Last Update : <?= date('Y-m-d H:i'); ?></span>
<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-red">
            <div class="inner text-center">
                <span style="font-size: 10em;"><?= $total_open > 0 ? '<span style="color: #ff1c00;">-' . number_format($total_open) . '</span>' : '0'; ?></span>
            </div>
            <a class="small-box-footer" href="#" style="font-size: 2em;">OPEN</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-teal">
            <div class="inner text-center">
                <span style="font-size: 10em;"><?= number_format($total_return); ?></span>
            </div>
            <a class="small-box-footer" href="#" style="font-size: 2em;">RETURN</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-orange">
            <div class="inner text-center">
                <span style="font-size: 10em;"><?= number_format($total_scrap); ?></span>
            </div>
            <a class="small-box-footer" href="#" style="font-size: 2em;">SCRAP</a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-orange">
            <div class="inner text-center">
                <span style="font-size: 10em;"><?= number_format($total_ok); ?></span>
            </div>
            <a class="small-box-footer" href="#" style="font-size: 2em;">REPAIRED</a>
        </div>
    </div>
</div>


<table class="table table-responsive table-bordered table-striped" id="detail-tbl">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th class="text-center">In Date</th>
            <th class="text-center">Section</th>
            <th class="text-center">Model</th>
            <th class="text-center">Dest.</th>
            <th class="text-center">PCB</th>
            <th>Defect</th>
            <th>Detail</th>
            <th>Cause</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($data_open) > 0) {
            $no = 1;
            foreach ($data_open as $key => $value) {
                ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td class="text-center"><?= date('d M\' Y', strtotime($value->in_date)); ?></td>
                    <td class="text-center"><?= $value->section; ?></td>
                    <td class="text-center"><?= $value->model; ?></td>
                    <td class="text-center"><?= $value->dest; ?></td>
                    <td class="text-center"><?= $value->pcb; ?></td>
                    <td><?= $value->defect; ?></td>
                    <td><?= $value->detail; ?></td>
                    <td><?= $value->cause; ?></td>
                </tr>
            <?php }
        }
        ?>
    </tbody>
</table>