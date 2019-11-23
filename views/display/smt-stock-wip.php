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
    'page_title' => 'SMT WIP Stock <span class="japanesse">(仕掛り在庫)</span>',
    'tab_title' => 'SMT WIP Stock ',
    'breadcrumbs_title' => 'SMT WIP Stock ',
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
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
        background-color: #595F66;
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #ddd;
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
            <th class="text-center">Target</th>
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
            <th>Stock LT to FA <span style="color: white;" class="japanesse">(総組までのLT在庫)</span></th>
            <th class="text-center">Qty</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="50%"><span class="description">Today (<?= date('d M \'y') ?>)</span></td>
            <td width="50%" class="actual text-center"><?= number_format($stock_arr[0]); ?> <span style="font-size: 0.5em">pcs</span></td>
        </tr>
        <tr>
            <td width="50%"><span class="description">Tomorrow</span></td>
            <td width="50%" class="actual text-center"><?= number_format($stock_arr[1]); ?> <span style="font-size: 0.5em">pcs</span></td>
        </tr>
        <tr>
            <td width="50%"><span class="description">Other</span></td>
            <td width="50%" class="actual text-center"><?= number_format($stock_arr[2]); ?> <span style="font-size: 0.5em">pcs</span></td>
        </tr>
    </tbody>
</table>