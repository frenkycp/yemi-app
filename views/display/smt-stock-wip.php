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

$title = 'WIP Stock';
$tab_title = 'WIP Stock';
if ($loc == 'WM03') {
    $title = 'SMT WIP Stock <span class="japanesse light-green">(仕掛り在庫)</span>';
    $tab_title = 'SMT WIP Stock ';
} elseif ($loc == 'WU01') {
    $title = 'SPU WIP Stock <span class="japanesse light-green"></span>';
    $tab_title = 'SMT WIP Stock ';
}

$this->title = [
    'page_title' => $title,
    'tab_title' => $tab_title,
    'breadcrumbs_title' => $tab_title,
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
        font-size: 28px;
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
<span style="font-size: 2em; color: white;">Last Update : <?= date('d M \'y H:i') ?></span>
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th class="text-center">Max</th>
            <th class="text-center">Actual</th>
            <th class="text-center" width="200px">Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            $txt_actual_class = ' text-green';
            $icon = '<i class="fa fa-circle-o text-green icon-status"></i>';;
            if ($total_stock > $target_stock) {
                $txt_actual_class = ' text-red';
                $icon = '<i class="fa fa-close text-red icon-status blinked"></i>';
            }
            ?>
            <td class="text-center target"><?= number_format($target_stock); ?> <span style="font-size: 0.5em">pcs</span></td>
            <td class="text-center actual<?= $txt_actual_class; ?>"><?= number_format($total_stock); ?> <span style="font-size: 0.5em">pcs</span></td>
            <td class="text-center"><?= $icon; ?></td>
        </tr>
    </tbody>
</table>
<br/>

<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th width="70%" style="font-size: 3.2em;">Stock LT to FA <span class="japanesse">(総組までのLT在庫)</span></th>
            <th width="30%" style="font-size: 3.2em;" class="text-center">Qty</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span class="description">Today (<?= date('d M \'y') ?>)</span></td>
            <td class="actual text-center"><?= number_format($stock_arr[0]); ?> <span style="font-size: 0.5em">pcs</span></td>
        </tr>
        <tr>
            <td><span class="description">Next Day</span></td>
            <td class="actual text-center"><?= number_format($stock_arr[1]); ?> <span style="font-size: 0.5em">pcs</span></td>
        </tr>
        <tr>
            <td><span class="description">Others</span></td>
            <td class="actual text-center"><?= number_format($stock_arr[2]); ?> <span style="font-size: 0.5em">pcs</span></td>
        </tr>
    </tbody>
</table>