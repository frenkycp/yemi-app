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
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 12px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
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
    #yesterday-tbl > tbody > tr > td{
        border:1px solid #777474;
        background: #000;
        color: #FFF;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 2px;
        //height: 100px;
    }
    #popup-tbl > tfoot > tr > td {
        font-weight: bold;
        background-color: rgba(0, 0, 150, 0.3);
    }
    .panel-title {
        font-size: 30px;
    }
    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    .summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
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
        <?= $form->field($model, 'period')->textInput(); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>

<div class="row" style="color: white;">
    <div class="col-md-6">
        <h3>Shipping Sales Report</h3>
        Update Date : <br/>
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th width="30%">Shipping Target</th>
                    <th width="15%" class="text-center">Qty</th>
                    <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Original <?= $this_month; ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_ORI_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_ORI_AMT); ?></td>
                </tr>
                <tr>
                    <td>Back Order <?= $last_month; ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_BO_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_BO_AMT); ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_TOTAL_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_PLAN_TOTAL_AMT); ?></td>
                </tr>
            </tbody>
        </table>
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th width="30%">Actual Shipping</th>
                    <th width="15%" class="text-center">Qty</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">% achieve</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Original <?= $this_month; ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_ORI_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_ORI_AMT); ?></td>
                    <td class="text-center"><?php
                    $pct = 0;
                    if ($data->SHIP_PLAN_ORI_AMT > 0) {
                        $pct = round($data->SHIP_ACT_ORI_AMT / $data->SHIP_PLAN_ORI_AMT * 100, 1);
                    }
                    echo $pct;
                    ?></td>
                </tr>
                <tr>
                    <td>Back Order <?= $last_month; ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_BO_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->SHIP_ACT_BO_AMT); ?></td>
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
    </div>
    <div class="col-md-6">
        <h3>Production Result</h3>
        Update Date : <br/>
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th width="30%">Production Target</th>
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
                    <td>Delay <?= $last_month; ?></td>
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
                    <th class="text-center">% achieve</th>
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
                        $pct = round($data->PRD_ACT_ORI_AMT / $data->PRD_PLAN_ORI_AMT * 100, 1);
                    }
                    echo $pct;
                    ?></td>
                </tr>
                <tr>
                    <td>Delay <?= $last_month; ?></td>
                    <td class="text-center"><?= number_format($data->PRD_ACT_DELAY_QTY); ?></td>
                    <td class="text-center"><?= number_format($data->PRD_ACT_DELAY_AMT); ?></td>
                    <td class="text-center">
                        <?php
                        $pct = 0;
                        if ($data->PRD_PLAN_ORI_AMT > 0) {
                            $pct = round($data->PRD_ACT_DELAY_AMT / $data->PRD_PLAN_DELAY_AMT * 100, 1);
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
                            $pct = round($data->PRD_ACT_TOTAL_AMT / $data->PRD_PLAN_TOTAL_AMT * 100, 1);
                        }
                        echo $pct;
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>