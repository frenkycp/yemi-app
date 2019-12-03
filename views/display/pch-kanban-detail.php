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
    'page_title' => 'Detail Payment',
    'tab_title' => 'Detail Payment',
    'breadcrumbs_title' => 'Detail Payment',
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
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
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .icon-status {font-size : 2em;}

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

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
$no = 1;
?>

<div class="panel panel-primary">
    <div class="panel-body">
        <table class="table table-responsive table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Period</th>
                    <th>Vendor Code</th>
                    <th>Vendor Name</th>
                    <th>Voucher No.</th>
                    <th>Invoice Act.</th>
                    <th>Do</th>
                    <th>Currency</th>
                    <th>Ammount</th>
                    <th>PIC</th>
                    <th>Division</th>
                    <th>Term</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $value): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $value['period']; ?></td>
                        <td><?= $value['vendor_code']; ?></td>
                        <td><?= $value['vendor_name']; ?></td>
                        <td><?= $value['voucher_no']; ?></td>
                        <td><?= $value['invoice_act']; ?></td>
                        <td><?= $value['do']; ?></td>
                        <td><?= $value['currency']; ?></td>
                        <td><?= $value['amount']; ?></td>
                        <td><?= $value['pic']; ?></td>
                        <td><?= $value['division']; ?></td>
                        <td><?= $value['term']; ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>