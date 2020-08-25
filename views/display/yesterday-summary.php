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
    'page_title' => null,
    'tab_title' => 'Yesterday Summary',
    'breadcrumbs_title' => 'Yesterday Summary'
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

// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_data_arr);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['yesterday-summary']),
]); ?>

<div style="margin: auto; width: 400px; padding-top: 20px;">
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'post_date')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'options' => [
                    'placeholder' => 'Enter date ...',
                    'class' => 'form-control text-center',
                    'onchange'=>'this.form.submit()',
                ],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
            ])->label('Date'); ?>
        </div>
        
        
    </div>

    <?php ActiveForm::end(); ?>
    <table class="table table-condensed summary-tbl" id="">
        <thead>
            <tr>
                <th colspan="2" class="">Production (<?= date('d M\' Y', strtotime($yesterday)); ?>) - FG<br/><span class="japanesse">生産予実績 （日次）</span></th>
                <th class="text-center">Daily</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left column-1">Plan</td>
                <td class="text-center column-2">計画</td>
                <td class="text-center column-3"><?= number_format($prod_data_daily_fg->PLAN_QTY); ?></td>
            </tr>
            <tr>
                <td class="text-left">Actual</td>
                <td class="text-center">実績</td>
                <td class="text-center"><?= number_format($prod_data_daily_fg->ACTUAL_QTY); ?></td>
            </tr>
            <tr>
                <td class="text-left">Balance</td>
                <td class="text-center">進度</td>
                <td class="text-center"><?= number_format($prod_data_daily_fg->ACTUAL_QTY - $prod_data_daily_fg->PLAN_QTY); ?></td>
            </tr>
            <tr style="<?= $tmp_fg_minus_daily ? '' : 'display: none;'; ?>">
                <td colspan="3" style="font-size: 12px;">
                    <?php
                    if ($tmp_fg_minus_daily) {
                        echo '<u>Top 3 Balance :</u><br/>';
                        foreach ($tmp_fg_minus_daily as $key => $value) { ?>
                            - <?= $value->ITEM; ?> | <?= $value->ITEM_DESC . ' ' . $value->DESTINATION; ?> | <span class="text-red"><?= number_format($value->BALANCE_QTY); ?></span><br/>
                        <?php
                        }
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-condensed summary-tbl" id="">
        <thead>
            <tr>
                <th colspan="2" class="">Production (<?= date('d M\' Y', strtotime($yesterday)); ?>) - KD<br/><span class="japanesse">生産予実績 （日次）</span></th>
                <th class="text-center">Daily</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left column-1">Plan</td>
                <td class="text-center column-2">計画</td>
                <td class="text-center column-3"><?= number_format($prod_data_daily_kd->PLAN_QTY); ?></td>
            </tr>
            <tr>
                <td class="text-left">Actual</td>
                <td class="text-center">実績</td>
                <td class="text-center"><?= number_format($prod_data_daily_kd->ACTUAL_QTY); ?></td>
            </tr>
            <tr>
                <td class="text-left">Balance</td>
                <td class="text-center">進度</td>
                <td class="text-center"><?= number_format($prod_data_daily_kd->ACTUAL_QTY - $prod_data_daily_kd->PLAN_QTY); ?></td>
            </tr>
            <tr style="<?= $tmp_kd_minus_daily ? '' : 'display: none;'; ?>">
                <td colspan="3" style="font-size: 12px;">
                    <?php
                    if ($tmp_kd_minus_daily) {
                        echo '<u>Top 3 Balance :</u><br/>';
                        foreach ($tmp_kd_minus_daily as $key => $value) { ?>
                            - <?= $value->ITEM; ?> | <?= $value->ITEM_DESC . ' ' . $value->DESTINATION; ?> | <span class="text-red"><?= number_format($value->BALANCE_QTY); ?></span><br/>
                        <?php
                        }
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-condensed summary-tbl" id="">
        <thead>
            <tr>
                <th colspan="2" class="">Production (<?= date('M\' Y', strtotime($yesterday)); ?>)<br/><span class="japanesse">生産予実績 （月次）</span></th>
                <th class="text-center">Monthly</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="column-1">Plan Acc.</td>
                <td class="text-center column-2">累計計画</td>
                <td class="text-center column-3"><?= number_format($prod_data_monthly->PLAN_QTY); ?></td>
            </tr>
            <tr>
                <td class="">Actual Acc.</td>
                <td class="text-center">累計実績</td>
                <td class="text-center"><?= number_format($prod_data_monthly->ACTUAL_QTY); ?></td>
            </tr>
            <tr>
                <td class="">Balance</td>
                <td class="text-center">進度</td>
                <td class="text-center"><?= number_format($prod_data_monthly->ACTUAL_QTY - $prod_data_monthly->PLAN_QTY); ?></td>
            </tr>
            <tr style="<?= $tmp_top_minus ? '' : 'display: none;'; ?>">
                <td colspan="3" style="font-size: 12px;">
                    <?php
                    if ($tmp_top_minus) {
                        echo '<u>Top 3 Balance :</u><br/>';
                        foreach ($tmp_top_minus as $key => $value) { ?>
                            - <?= $value->ITEM; ?> | <?= $value->ITEM_DESC . ' ' . $value->DESTINATION; ?> | <span class="text-red"><?= number_format($value->BALANCE_QTY); ?></span><br/>
                        <?php
                        }
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-condensed summary-tbl" id="">
        <thead>
            <tr>
                <th colspan="2" class="">Shipping (<?= date('d M\' Y', strtotime($yesterday)); ?>)<br/><span class="japanesse">出荷実績 (日次)</span></th>
                <th class="text-center">Daily</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bu_arr as $key => $value): ?>
                <tr style="<?= $value == 0 ? 'display: none;' : ''; ?>">
                    <td class=""><?= $key; ?></td>
                    <td class="text-center">実績</td>
                    <td class="text-center"><?= number_format($value); ?></td>
                </tr>
            <?php endforeach ?>
            <tr>
                <td class="column-1" style="font-weight: bold;">Total</td>
                <td class="text-center column-2" style="font-weight: bold;">合計</td>
                <td class="text-center column-3" style="font-weight: bold;"><?= number_format($total_shipping); ?></td>
            </tr>
        </tbody>
    </table>

    <table class="table table-condensed summary-tbl" id="">
        <thead>
            <tr>
                <th colspan="2" class="">FA OQC NG Rate (<?= date('d M\' Y', strtotime($yesterday)); ?>)<br/><span class="japanesse">総組 OQC不良率</span></th>
                <th class="text-center">Daily</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="column-1">Actual</td>
                <td class="text-center column-2">実績</td>
                <td class="text-center column-3"><?= $ng_rate; ?>%</td>
            </tr>
            <tr style="<?= $tmp_top_ng ? '' : 'display: none;'; ?>">
                <td colspan="3" style="font-size: 12px;">
                    <?php
                    if ($tmp_top_ng) {
                        echo '<u>Top 3 NG Qty :</u><br/>';
                        foreach ($tmp_top_ng as $key => $value) { ?>
                            - <?= $value->gmc_desc; ?> ( <span class="text-red"><?= 'NG : ' . number_format($value->ng_qty); ?></span>)<br/>
                        <?php
                        }
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-condensed summary-tbl" id="">
        <thead>
            <tr>
                <th colspan="2" class="">Attendance Rate (<?= date('d M\' Y', strtotime($yesterday)); ?>)<br/><span class="japanesse">出勤率</span></th>
                <th class="text-center column-3"><?= $attendance_rate; ?>%</th>
            </tr>
        </thead>
    </table>

    <i>Source : MITA</i><br/>
    <i>Last Update : <?= date('Y-m-d H:i:s'); ?></i>
</div>