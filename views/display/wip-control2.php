<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Wood Working - WIP Control "BEACON" <span class="japanesse light-green"></span>',
    'tab_title' => 'Wood Working - WIP Control "BEACON" ',
    'breadcrumbs_title' => 'Wood Working - WIP Control "BEACON" ',
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

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        font-size: 2.5em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        height: 120px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important; font-weight: bold !important;}
    .description {font-size: 2.2em; padding-left: 10px;}
    .text-red{color: #ff1c00 !important;}
");


date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 30000); // milliseconds
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
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th></th>
            <th class="text-center" width="25%">Target</th>
            <th class="text-center" width="25%">Actual</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            $target_total = 6000;
            if ($data['total_wip'] >= $target_total) {
                $total_txt_class = ' text-red';
                $total_src_img = '<i style="font-size: 2.5em;" class="fa fa-close text-red blinked"></i>';
            } else {
                $total_txt_class = ' text-green';
                $total_src_img = '<i style="font-size: 2.5em;" class="fa fa-circle-o text-green"></i>';
            }
            ?>
            <td>Jumlah WIP WW</td>
            <td class="text-center target">< <?= number_format($target_total); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $total_txt_class; ?>"><?= number_format($data['total_wip']); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center"><?= $total_src_img; ?></td>
        </tr>
        <tr>
            <?php
            $target_rsaw = 2000;
            if ($data['running_saw'] >= $target_rsaw) {
                $rsaw_txt_class = ' text-red';
                $rsaw_src_img = '<i style="font-size: 2.5em;" class="fa fa-close text-red blinked"></i>';
            } else {
                $rsaw_txt_class = ' text-green';
                $rsaw_src_img = '<i style="font-size: 2.5em;" class="fa fa-circle-o text-green"></i>';
            }
            ?>
            <td>WIP - Running Saw</td>
            <td class="text-center target">< <?= number_format($target_rsaw); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $rsaw_txt_class; ?>"><?= number_format($data['running_saw']); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center"><?= $rsaw_src_img; ?></td>
        </tr>
        <tr>
            <?php
            $target_det = 2000;
            if ($data['det'] >= $target_det) {
                $det_txt_class = ' text-red';
                $det_src_img = '<i style="font-size: 2.5em;" class="fa fa-close text-red blinked"></i>';
            } else {
                $det_txt_class = ' text-green';
                $det_src_img = '<i style="font-size: 2.5em;" class="fa fa-circle-o text-green"></i>';
            }
            ?>
            <td>WIP - DET</td>
            <td class="text-center target">< <?= number_format($target_det); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $det_txt_class; ?>"><?= number_format($data['det']); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center"><?= $det_src_img; ?></td>
        </tr>
        <tr>
            <?php
            $target_end = 4000;
            if ($data['end'] >= $target_end) {
                $end_txt_class = ' text-red';
                $end_src_img = '<i style="font-size: 2.5em;" class="fa fa-close text-red blinked"></i>';
            } else {
                $end_txt_class = ' text-green';
                $end_src_img = '<i style="font-size: 2.5em;" class="fa fa-circle-o text-green"></i>';
            }
            ?>
            <td>WIP - End</td>
            <td class="text-center target">< <?= number_format($target_end); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $end_txt_class; ?>"><?= number_format($data['end']); ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center"><?= $end_src_img; ?></td>
        </tr>
    </tbody>
</table>

<span style="color: white; font-size: 1.5em;">Jumlah WIP WW (Breakdown)</span>
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th width="33%" class="text-center">L - Series</th>
            <th width="33%" class="text-center">HS - Series</th>
            <th width="33%" class="text-center">P40 - Series</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center actual"><?= number_format($qty_series['l_series']) ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual"><?= number_format($qty_series['hs_series']) ?> <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual"><?= number_format($qty_series['p40_series']) ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
    </tbody>
</table>