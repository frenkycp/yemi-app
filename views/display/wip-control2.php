<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Wood Working - WIP Control "BEACON" <span class="japanesse"></span>',
    'tab_title' => 'Wood Working - WIP Control "BEACON" ',
    'breadcrumbs_title' => 'Wood Working - WIP Control "BEACON" ',
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #00ff2b;}
    .control-label {color: white;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    //.container {width: auto;}
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
        font-size: 4em;
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
<span style="color: white">Last Update : <?= date('Y-m-d H:i'); ?></span>
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th></th>
            <th class="text-center" width="25%">Target</th>
            <th class="text-center" width="25%">Actual</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Jumlah WIP WW</td>
            <td class="text-center target">< 6,000 <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual"><?= number_format($data['total_wip']); ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
        <tr>
            <?php
            if ($data['running_saw'] >= 1000) {
                $rsaw_txt_class = ' text-red';
            } else {
                //$rsaw_txt_class = ' text-green';
            }
            ?>
            <td>WIP - Running Saw</td>
            <td class="text-center target">< 1,000 <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $rsaw_txt_class; ?>"><?= number_format($data['running_saw']); ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
        <tr>
            <?php
            if ($data['det'] >= 1000) {
                $det_txt_class = ' text-red';
            } else {
                //$det_txt_class = ' text-green';
            }
            ?>
            <td>WIP - DET</td>
            <td class="text-center target">< 1,000 <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual<?= $det_txt_class; ?>"><?= number_format($data['det']); ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
        <tr>
            <td>WIP - End</td>
            <td class="text-center target">< 4,000 <span style="font-size: 0.3em;">PCS</span></td>
            <td class="text-center actual"><?= number_format($data['end']); ?> <span style="font-size: 0.3em;">PCS</span></td>
        </tr>
    </tbody>
</table>