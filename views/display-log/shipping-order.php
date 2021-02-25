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
    'page_title' => 'Shipping Order <span class="japanesse light-green"></span>',
    'tab_title' => 'Shipping Order',
    'breadcrumbs_title' => 'Shipping Order'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

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
        background-color: rgba(255, 229, 153, 0.5);
        color: black;
        font-size: 14px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
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

    #my-title {
        font-size: 28px;
        font-weight: bold;
        background-color: #a6ff79;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .bg-red-mod {
        background-color: #ff5945 !important;
    }

    .total-container {
        font-size: 24px;
        font-weight: bold;
    }

    .total-pct {
        font-size: 18px;
        font-style: italic;
    }
    .container-qty {
        width: 130px;
    }
    .detail-confirmed {
        font-size: 18px;
    }

    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    #summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['shipping-order']),
]); ?>
<div style="margin: auto; width: 1000px; padding-top: 20px;" id="display-container">
    
    <div class="row">
        <div class="col-sm-10">
            <div id="my-title" class="text-center">
                YEMI SHIPPING ORDER <?= $period_name; ?>
            </div>
        </div>
        <div class="col-sm-2" style="padding-top: 3px;">
            <?= $form->field($model, 'period')->textInput()->label(false); ?>
        </div>
    </div>
    <table class="table summary-tbl" style="display: none;">
        <thead>
            <tr>
                <th class="">Unit</th>
                <th class="text-center container-qty">PLAN 計画</th>
                <th class="text-center container-qty">ETD SUB 出荷</th>
                <th class="text-center container-qty">At Port 港</th>
                <th class="text-center container-qty">Not yet Stuffing<br/>未スタッフィング</th>
                <th class="text-center container-qty">CONFIRMED<br/>確保済み</th>
                <th class="text-center container-qty">NOT CONFIRMED<br/>未確保</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="">TEU</td>
                <td class="text-center"><?= $data['total_plan_teu']; ?></td>
                <td class="text-center"><?= $data['total_etd_sub_teu']; ?></td>
                <td class="text-center"><?= $data['total_at_port_teu']; ?></td>
                <td class="text-center"><?= $data['not_yet_stuffing_teu']; ?></td>
                <td class="text-center"><?= $data['total_confirm_teu']; ?></td>
                <td class="text-center"><?= $data['total_not_confirm_teu']; ?></td>
            </tr>
            <tr>
                <td class="">CONTAINER</td>
                <td class="text-center"><?= $data['total_plan']; ?></td>
                <td class="text-center"><?= $data['total_etd_sub']; ?></td>
                <td class="text-center"><?= $data['total_at_port']; ?></td>
                <td class="text-center"><?= $data['not_yet_stuffing']; ?></td>
                <td class="text-center"><?= $data['total_confirm']; ?></td>
                <td class="text-center"><?= $data['total_not_confirm']; ?></td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-success text-center">
                <div class="panel-heading">
                    <h3 class="panel-title">PLAN (PCS)</h3>
                </div>
                <div class="panel-body no-padding">
                    <span class="total-container"><?= $data['total_plan']; ?></span> <span class="total-pct">(100%)</span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-success text-center">
                <div class="panel-heading">
                    <h3 class="panel-title">CONFIRMED (PCS)</h3>
                </div>
                <div class="panel-body no-padding" style="">
                    <span class="total-container"><?= $data['total_confirm']; ?></span> <span class="total-pct">(<?= $data['confirm_pct']; ?>%)</span>
                    <hr style="margin: 5px 10px;">
                    <span class="detail-confirmed">ETD Port : <b><?= $data['total_etd_sub']; ?></b> <span>
                        (<?= $data['total_plan'] > 0 ? round(($data['total_etd_sub'] / $data['total_plan']) * 100) : '0'; ?>%)</span>
                    </span><br/>
                    <span class="detail-confirmed">At Port : <b><?= $data['total_at_port']; ?></b> <span>
                        (<?= $data['total_plan'] > 0 ? round(($data['total_at_port'] / $data['total_plan']) * 100) : '0'; ?>%)
                    </span></span><br/>
                    <span class="detail-confirmed">Not Yet Stuffing : <b><?= $data['not_yet_stuffing']; ?></b> <span>
                        (<?= $data['total_plan'] > 0 ? round(($data['not_yet_stuffing'] / $data['total_plan']) * 100) : '0'; ?>%)
                    </span></span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-success text-center">
                <div class="panel-heading">
                    <h3 class="panel-title">NOT CONFIRMED (PCS)</h3>
                </div>
                <div class="panel-body no-padding">
                    <span class="total-container"><?= $data['total_not_confirm']; ?></span> <span class="total-pct">(<?= $data['not_confirm_pct']; ?>%)</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-info text-center">
                <div class="panel-heading">
                    <h3 class="panel-title">PLAN (TEU)</h3>
                </div>
                <div class="panel-body no-padding">
                    <span class="total-container"><?= $data['total_plan_teu']; ?></span> <span class="total-pct">(100%)</span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-info text-center">
                <div class="panel-heading">
                    <h3 class="panel-title">CONFIRMED (TEU)</h3>
                </div>
                <div class="panel-body no-padding" style="">
                    <span class="total-container"><?= $data['total_confirm_teu']; ?></span> <span class="total-pct">(<?= $data['confirm_pct_teu']; ?>%)</span>
                    <hr style="margin: 5px 10px;">
                    <span class="detail-confirmed">ETD Port : <b><?= $data['total_etd_sub_teu']; ?></b> <small>
                        (<?= $data['total_plan_teu'] > 0 ? round(($data['total_etd_sub_teu'] / $data['total_plan_teu']) * 100) : '0'; ?>%)
                    </small></span><br/>
                    <span class="detail-confirmed">At Port : <b><?= $data['total_at_port_teu']; ?></b> <small>
                        (<?= $data['total_plan_teu'] > 0 ? round(($data['total_at_port_teu'] / $data['total_plan_teu']) * 100) : '0'; ?>%)
                    </small></span><br/>
                    <span class="detail-confirmed">Not Yet Stuffing : <b><?= $data['not_yet_stuffing_teu']; ?></b> <small>
                        (<?= $data['total_plan_teu'] > 0 ? round(($data['not_yet_stuffing_teu'] / $data['total_plan_teu']) * 100) : '0'; ?>%)
                    </small></span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-info text-center">
                <div class="panel-heading">
                    <h3 class="panel-title">NOT CONFIRMED (TEU)</h3>
                </div>
                <div class="panel-body no-padding">
                    <span class="total-container"><?= $data['total_not_confirm_teu']; ?></span> <span class="total-pct">(<?= $data['not_confirm_pct_teu']; ?>%)</span>
                </div>
            </div>
        </div>
    </div>
    <table class="table summary-tbl">
        <thead>
            <tr>
                <th class="text-center">DESTINATION</th>
                <th class="text-center" style="width: 20%;">PLAN (PCS)</th>
                <th class="text-center" style="width: 20%;">CONFIRMED (PCS)</th>
                <th class="text-center" style="width: 20%;">NOT CONFIRMED (PCS)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_arr as $key => $value): ?>
                <tr>
                    <td class="text-center"><?= $key; ?></td>
                    <td class="text-center"><?= number_format($value['plan']); ?></td>
                    <td class="text-center"><?= number_format($value['confirm']); ?></td>
                    <td class="text-center<?= $value['not_confirm'] > 0 ? ' bg-red-mod' : '' ?>"><?= number_format($value['not_confirm']); ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php ActiveForm::end(); ?>