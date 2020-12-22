<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = [
    'page_title' => 'JIT Parts - ETD Supplier Based',
    'tab_title' => 'JIT Parts - ETD Supplier Based',
    'breadcrumbs_title' => 'JIT Parts - ETD Supplier Based'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    //.form-control, .control-label {background-color: #FFF; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #FFF;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: white;
        color: black;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #777474 !important;
        background-color: rgb(255, 229, 153);
        color: black;
        font-size: 16px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
        font-weight: normal;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: black !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: white;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .column-1 {width: 40%;}
    .column-2 {width: 30%;}
    .column-3 {width: 30%;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //#summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);
$this->registerJsFile('@web/js/html2canvas.min.js');

$script = '
    html2canvas(document.querySelector("#table1")).then(canvas => {
        document.querySelector("#display-container").appendChild(canvas);
    });
';
$this->registerJs($script, View::POS_READY);

// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_data_arr);
echo '</pre>';*/
?>

<div style="margin: auto; padding-top: 10px;" id="display-container">
    <div class="text-center" style="font-size: 30px; font-weight: bold; padding-bottom: 10px;">JIT Parts - ETD Supplier Based (Status : DEPARTURE)</div>
    <table class="table summary-tbl">
        <thead>
            <tr>
                <th class="text-center">Booking ID</th>
                <th class="text-center">Vendor Code</th>
                <th class="">Vendor Name</th>
                <th class="text-center" style="width: 115px;">Pick-up Plan</th>
                <th class="text-center" style="width: 115px;">Pick-up Actual</th>
                <th class="text-center">Shipper</th>
                <th class="text-center">Item</th>
                <th class="">Item Description</th>
                <th class="text-center" style="width: 90px;">Order Qty</th>
                <th class="text-center" style="width: 90px;">Rcv. Qty</th>
                <th class="text-center" style="width: 90px;">BO Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $value): ?>
                <tr>
                    <td class="text-center"><?= $value['BOOKING_ID']; ?></td>
                    <td class="text-center"><?= $value['PUR_LOC']; ?></td>
                    <td class=""><?= $value['USER_DESC']; ?></td>
                    <td class="text-center"><?= date('d M\' Y', strtotime($value['PICKUP_PLAN'])); ?></td>
                    <td class="text-center"><?= date('d M\' Y H:i:s', strtotime($value['PICKUP_ACTUAL'])); ?></td>
                    <td class="text-center"><?= $value['SHIPPER']; ?></td>
                    <td class="text-center"><?= $value['ITEM']; ?></td>
                    <td class=""><?= $value['ITEM_DESC']; ?></td>
                    <td class="text-center"><?= number_format($value['ORDER_QTY']); ?></td>
                    <td class="text-center"><?= number_format($value['RCV_QTY']); ?></td>
                    <td class="text-center"><?= number_format($value['BO_QTY']); ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>