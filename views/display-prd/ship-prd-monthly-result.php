<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use app\models\TraceItemScrap;
use app\models\ShipPrdDelayInformation;

$this->title = [
    'page_title' => 'Shipping & Production Monthly Result <span class="japanesse light-green"></span>',
    'tab_title' => 'Shipping & Production Monthly Result',
    'breadcrumbs_title' => 'Shipping & Production Monthly Result'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .badge {font-weight: normal;}
    .cause-category {
        font-weight: bold;
        font-size: 1.2em;
    }
    .text-red {
        color: #d47575 !important;
    }

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.5px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 16px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
        font-weight: normal;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: white !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: yellow;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .table-delay-info {
        border-top: 0px !important;
    }
    .table {
        letter-spacing: 1.5px;
    }
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .bg-yellow-mod {background-color: yellow !important;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}
    .expired-um {
        font-size: 60px;
        font-weight: bold;
        border: 1px solid black;
    }
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

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

$this_month = date('M\'y', strtotime($model->period . '01'));
$last_month = date('M\'y', strtotime($model->period . '01 -1 month'));

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['ship-prd-monthly-result']),
]); ?>

<div class="row" style="padding-top: 10px;">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->textInput([
            'onchange' => 'this.form.submit();',
            'readonly' => true,
            'class' => 'bg-black'
        ])->label('Period : '); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>

<div class="row" style="color: white;">
    <div class="col-md-6">
        <h3 style="margin-top: 5px;">Shipping Sales Report</h3>
        Update Date : <?= $data->UPDATE_DATE == null ? '-' : date('d-F-y', strtotime($data->UPDATE_DATE)); ?><br/>
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th width="30%">Shipping Target</th>
                    <th width="15%" class="text-center">Qty</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Containers</th>
                    <th width="20%" class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Original <?= $this_month; ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_ORI_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_ORI_AMT); ?></td>
                    <td class="text-center"><?= $data->SHIP_PLAN_ORI_CNT == null ? '' : number_format($data->SHIP_PLAN_ORI_CNT) . ' TEU'; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Back Order</td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_BO_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_BO_AMT); ?></td>
                    <td class="text-center"><?= $data->SHIP_PLAN_BO_CNT == null ? '' : number_format($data->SHIP_PLAN_BO_CNT) . ' TEU'; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_TOTAL_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_TOTAL_AMT); ?></td>
                    <td class="text-center"><?= $data->SHIP_PLAN_TOTAL_CNT == null ? '' : number_format($data->SHIP_PLAN_TOTAL_CNT) . ' TEU'; ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th width="30%">Actual Shipping</th>
                    <th width="15%" class="text-center">Qty</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Containers</th>
                    <th width="20%" class="text-center">% achieve (Amt.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Original <?= $this_month; ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_ORI_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_ORI_AMT); ?></td>
                    <td class="text-center"><?= $data->SHIP_ACT_ORI_CNT == null ? '' : number_format($data->SHIP_ACT_ORI_CNT) . ' TEU'; ?></td>
                    <td class="text-center"><?php
                    $pct = 0;
                    if ($data->SHIP_PLAN_ORI_AMT > 0) {
                        $pct = round($data->SHIP_ACT_ORI_AMT / $data->SHIP_PLAN_ORI_AMT * 100, 1);
                    }
                    echo $pct;
                    ?></td>
                </tr>
                <tr>
                    <td>Back Order</td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_BO_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_BO_AMT); ?></td>
                    <td class="text-center"><?= $data->SHIP_ACT_BO_CNT == null ? '' : number_format($data->SHIP_ACT_BO_CNT) . ' TEU'; ?></td>
                    <td class="text-center"><?php
                    $pct = 0;
                    if ($data->SHIP_PLAN_BO_AMT > 0) {
                        $pct = round($data->SHIP_ACT_BO_AMT / $data->SHIP_PLAN_BO_AMT * 100, 1);
                    }
                    echo $pct;
                    ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_TOTAL_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_TOTAL_AMT); ?></td>
                    <td class="text-center"><?= $data->SHIP_ACT_TOTAL_CNT == null ? '' : number_format($data->SHIP_ACT_TOTAL_CNT) . ' TEU'; ?></td>
                    <td class="text-center"><?php
                    $pct = 0;
                    if ($data->SHIP_PLAN_TOTAL_AMT > 0) {
                        $pct = round($data->SHIP_ACT_TOTAL_AMT / $data->SHIP_PLAN_TOTAL_AMT * 100, 1);
                    }
                    echo $pct;
                    ?></td>
                </tr>
            </tbody>
        </table>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Delay Shipment Information</h3>
            </div>
            <div class="panel-body" style="background-color: black;">
                <?php
                $delay_info = ShipPrdDelayInformation::find()
                ->where([
                    'PERIOD' => $model->period,
                    'INF_CATEGORY' => 'S'
                ])
                ->all();

                if (count($delay_info) == 0) {
                    echo 'No Delay Information...';
                } else {
                    ?>
                    <table class="table" style="margin-bottom: 0px;">
                        <thead>
                            <tr style="font-size: 1.2em;">
                                <th width="10%"></th>
                                <th width="25%"></th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Containers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="cause-category">1. Eksternal Cause</td>
                            </tr>
                            <?php
                            $subtotal_qty1 = $subtotal_amt1 = $subtotal_container1 = 0;
                            foreach ($delay_info as $key => $value) {
                                if ($value->CAUSE_CATEGORY == 'EXT') {
                                    $subtotal_qty1 += $value->QTY;
                                    $subtotal_amt1 += $value->AMOUNT;

                                    $total_container = '';
                                    if ($value->CONTAINERS != null) {
                                        $total_container = $value->CONTAINERS . ' TEU';
                                        $subtotal_container1 += $value->CONTAINERS;
                                    }
                                    ?>
                                    <tr>
                                        <td class="table-delay-info"></td>
                                        <td class="table-delay-info"><?= $value->CAUSE_DESC; ?></td>
                                        <td class="table-delay-info"><?= number_format($value->QTY); ?></td>
                                        <td class="table-delay-info"><?= number_format($value->AMOUNT); ?></td>
                                        <td class="table-delay-info"><?= $total_container; ?></td>
                                    </tr>
                                <?php }
                            }
                            ?>
                            <tr style="font-weight: bold;">
                                <td class="table-delay-info"></td>
                                <td class="">Subtotal</td>
                                <td class=""><?= number_format($subtotal_qty1); ?></td>
                                <td class=""><?= number_format($subtotal_amt1); ?></td>
                                <td class=""><?= $subtotal_container1; ?> TEU</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="table-delay-info"></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="table-delay-info cause-category">2. Internal Cause</td>
                            </tr>
                            <?php
                            $subtotal_qty2 = $subtotal_amt2 = $subtotal_container2 = 0;
                            foreach ($delay_info as $key => $value) {
                                if ($value->CAUSE_CATEGORY == 'INT') {
                                    $subtotal_qty2 += $value->QTY;
                                    $subtotal_amt2 += $value->AMOUNT;

                                    $total_container = '';
                                    if ($value->CONTAINERS != null) {
                                        $total_container = $value->CONTAINERS . ' TEU';
                                        $subtotal_container2 += $value->CONTAINERS;
                                    }
                                    ?>
                                    <tr>
                                        <td class="table-delay-info"></td>
                                        <td class="table-delay-info"><?= $value->CAUSE_DESC; ?></td>
                                        <td class="table-delay-info"><?= number_format($value->QTY); ?></td>
                                        <td class="table-delay-info"><?= number_format($value->AMOUNT); ?></td>
                                        <td class="table-delay-info"><?= $total_container; ?></td>
                                    </tr>
                                <?php }
                            }
                            ?>
                            <tr style="font-weight: bold;">
                                <td class="table-delay-info"></td>
                                <td class="">Subtotal</td>
                                <td class=""><?= number_format($subtotal_qty2); ?></td>
                                <td class=""><?= number_format($subtotal_amt2); ?></td>
                                <td class=""></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="table-delay-info"></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td class="table-delay-info"></td>
                                <td class="table-delay-info">Total Delay</td>
                                <td class="table-delay-info"><?= number_format($subtotal_qty1 + $subtotal_qty2); ?></td>
                                <td class="table-delay-info"><?= number_format($subtotal_amt1 + $subtotal_amt2); ?></td>
                                <td class="table-delay-info"></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= Html::img('@web/uploads/SHIPPING & PRODUCTION/DELAY_SHIPPING_202105.png', ['alt' => 'My logo', 'width' => '100%']); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h3>Production Result</h3>
        Update Date : <?= $data->UPDATE_DATE == null ? '-' : date('d-F-y', strtotime($data->UPDATE_DATE)); ?><br/>
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th width="30%">Production Target <small><i>(End of Month)</i></small></th>
                    <th width="15%" class="text-center">Qty</th>
                    <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $this_month; ?></td>
                    <td class="text-center"><?= number_format($data->PRD_PLAN_ORI_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->PRD_PLAN_ORI_AMT); ?></td>
                </tr>
                <tr>
                    <td>Delay</td>
                    <td class="text-center"><?= number_format($data->PRD_PLAN_DELAY_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->PRD_PLAN_DELAY_AMT); ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-center"><?= number_format($data->PRD_PLAN_TOTAL_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->PRD_PLAN_TOTAL_AMT); ?></td>
                </tr>
            </tbody>
        </table>
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th width="30%">Output Production</th>
                    <th width="15%" class="text-center">Qty</th>
                    <th class="text-center">Amount</th>
                    <th width="20%" class="text-center">% achieve (Qty)</th>
                    <th width="20%" class="text-center">% achieve (Amt.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $this_month; ?></td>
                    <td class="text-center"><?= number_format($data->PRD_ACT_ORI_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->PRD_ACT_ORI_AMT); ?></td>
                    <td class="text-center"><?php
                    $pct = 0;
                    if ($data->PRD_PLAN_ORI_AMT > 0) {
                        $pct = round($data->PRD_ACT_ORI_QTY / $data->PRD_PLAN_ORI_QTY * 100, 1);
                        if ($pct == 100 && $data->PRD_ACT_ORI_QTY < $data->PRD_PLAN_ORI_QTY) {
                            $pct = round($data->PRD_ACT_ORI_QTY / $data->PRD_PLAN_ORI_QTY * 100, 2);
                        }
                    }
                    echo $pct;
                    ?></td>
                    <td class="text-center"><?php
                    $pct = 0;
                    if ($data->PRD_PLAN_ORI_AMT > 0) {
                        $pct = round($data->PRD_ACT_ORI_AMT / $data->PRD_PLAN_ORI_AMT * 100, 1);
                        if ($pct == 100 && $data->PRD_ACT_ORI_AMT < $data->PRD_ACT_ORI_AMT) {
                            $pct = round($data->PRD_ACT_ORI_AMT / $data->PRD_ACT_ORI_AMT * 100, 2);
                        }
                    }
                    echo $pct;
                    ?></td>
                </tr>
                <tr>
                    <td>Delay</td>
                    <td class="text-center"><?= number_format($data->PRD_ACT_DELAY_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->PRD_ACT_DELAY_AMT); ?></td>
                    <td class="text-center">
                        <?php
                        $pct = 0;
                        if ($data->PRD_PLAN_ORI_AMT > 0) {
                            $pct = round($data->PRD_ACT_DELAY_QTY / $data->PRD_PLAN_DELAY_QTY * 100, 1);
                            if ($pct == 100 && $data->PRD_ACT_DELAY_QTY < $data->PRD_PLAN_DELAY_QTY) {
                                $pct = round($data->PRD_ACT_DELAY_QTY / $data->PRD_PLAN_DELAY_QTY * 100, 2);
                            }
                        }
                        echo $pct;
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        $pct = 0;
                        if ($data->PRD_PLAN_ORI_AMT > 0) {
                            $pct = round($data->PRD_ACT_DELAY_AMT / $data->PRD_PLAN_DELAY_AMT * 100, 1);
                            if ($pct == 100 && $data->PRD_ACT_DELAY_AMT < $data->PRD_PLAN_DELAY_AMT) {
                                $pct = round($data->PRD_ACT_DELAY_AMT / $data->PRD_PLAN_DELAY_AMT * 100, 2);
                            }
                        }
                        echo $pct;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-center"><?= number_format($data->PRD_ACT_TOTAL_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->PRD_ACT_TOTAL_AMT); ?></td>
                    <td class="text-center">
                        <?php
                        $pct = 0;
                        if ($data->PRD_PLAN_ORI_AMT > 0) {
                            $pct = round($data->PRD_ACT_TOTAL_QTY / $data->PRD_PLAN_TOTAL_QTY * 100, 1);
                            if ($pct == 100 && $data->PRD_ACT_TOTAL_QTY < $data->PRD_PLAN_TOTAL_QTY) {
                                $pct = round($data->PRD_ACT_TOTAL_QTY / $data->PRD_PLAN_TOTAL_QTY * 100, 2);
                            }
                        }
                        echo $pct;
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        $pct = 0;
                        if ($data->PRD_PLAN_ORI_AMT > 0) {
                            $pct = round($data->PRD_ACT_TOTAL_AMT / $data->PRD_PLAN_TOTAL_AMT * 100, 1);
                            if ($pct == 100 && $data->PRD_ACT_TOTAL_AMT < $data->PRD_PLAN_TOTAL_AMT) {
                                $pct = round($data->PRD_ACT_TOTAL_AMT / $data->PRD_PLAN_TOTAL_AMT * 100, 2);
                            }
                        }
                        echo $pct;
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Delay Production Information</h3>
            </div>
            <div class="panel-body" style="background-color: black;">
                <?php
                $delay_info = ShipPrdDelayInformation::find()
                ->where([
                    'PERIOD' => $model->period,
                    'INF_CATEGORY' => 'P'
                ])
                ->all();

                if (count($delay_info) == 0) {
                    echo 'No Delay Information...';
                } else {
                    ?>
                    <table class="table" style="margin-bottom: 0px;">
                        <thead>
                            <tr>
                                <th width="20%"></th>
                                <th width="20%">Model</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($delay_info as $key => $value): ?>
                                <tr>
                                    <td class="table-delay-info"><?= $value->CAUSE_DESC; ?></td>
                                    <td class="table-delay-info"><?= $value->MODEL_NAME; ?></td>
                                    <td class="table-delay-info text-red">(<?= number_format($value->QTY); ?>)</td>
                                    <td class="table-delay-info text-red">(<?= number_format($value->AMOUNT); ?>)</td>
                                    <td class="table-delay-info"><?= $value->REASON; ?></td>
                                </tr>
                            <?php endforeach ?>
                            
                        </tbody>
                    </table>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>