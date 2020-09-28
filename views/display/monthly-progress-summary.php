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
    'page_title' => '<span class="japanesse">BU別の生産進捗</span> (Progress production by BU) <span class="japanesse light-green"></span>',
    'tab_title' => 'BU別の生産進捗 (Progress production by BU)',
    'breadcrumbs_title' => 'BU別の生産進捗 (Progress production by BU)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
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

    #summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #summary-tbl > thead > tr > th{
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
    #summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: yellow;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    #summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

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
// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['monthly-progress-summary']),
]); ?>

<div class="row" style="padding-top: 5px;">
    <div class="col-md-2">
        <?= $form->field($model, 'fiscal_year')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
                //'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
    
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    <div class="col-md-1">
        <?= $form->field($model, 'code')->hiddenInput()->label(false); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>

<table class="table" id="summary-tbl">
    <thead>
        <tr>
            <th>BU (%)</th>
            <?php foreach ($period_arr as $period): ?>
                <th class="text-center"><?= $period; ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $key => $value): ?>
            <tr>
                <td><?= $key; ?></td>
                <?php foreach ($value as $value2): ?>
                    <td class="text-center" style="<?= $value2['pct'] >= 100 ? 'color: #00ff00;' : ''; ?>"><span title="<?= number_format($value2['plan']) . ' / ' . number_format($value2['actual']); ?>"><?= $value2['pct'] . ''; ?></span></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<hr style="margin: 0px;">

<div class="row">
    <div class="col-sm-12 text-center">
        <span style="color: white; font-size: 2em;"><span class="japanesse">主な遅れ製品</span>  (Top Minus xxxx ) </span>
    </div>
</div>

<hr style="margin: 0px;">
<div class="row">
    <?php foreach ($top_minus as $key => $value): ?>
        <div class="col-sm-6 text-center" style="color: white; letter-spacing: 1.5px; padding: 3px;">
            <?= $value->ITEM . ' | ' . $value->ITEM_DESC . ' | <span class="text-red">USD ' . number_format($value->BALANCE_AMT_ALLOC) . '</span>'; ?>
        </div>
    <?php endforeach ?>
</div>