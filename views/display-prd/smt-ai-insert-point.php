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
    'page_title' => 'PT. YEMI Insertion/Mounting Qty <span class="japanesse light-green"></span>',
    'tab_title' => 'PT. YEMI Insertion/Mounting Qty',
    'breadcrumbs_title' => 'PT. YEMI Insertion/Mounting Qty'
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
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //#summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
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
$total_kwh = 0;


/*echo '<pre>';
print_r($period_arr);
echo '</pre>';*/

//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['smt-ai-insert-point']),
]); ?>

<div style="font-size: 20px; margin-bottom: 5px; padding-top: 10px;"><b>PT. YEMI Insertion/Mounting Qty - <span class="japanesse">自装本数（本）</b></span></div>

<div class="row">
    <div class="col-sm-6">
        
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'fiscal_year')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
                        'onchange'=>'this.form.submit()'
                    ]
                ); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row" style="letter-spacing: 2px;">
                    <div class="col-sm-3 text-center">
                        <span>JV = 0.75</span>
                    </div>
                    <div class="col-sm-3 text-center">
                        <span>AV = 0.2</span>
                    </div>
                    <div class="col-sm-3 text-center">
                        <span>RG = 0.4</span>
                    </div>
                    <div class="col-sm-3 text-center">
                        <span>SMT = 0.21</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<table class="table summary-tbl table-condensed">
    <thead>
        <tr>
            <th rowspan="2" class="text-center">PERIOD</th>
            <th rowspan="2" class="text-center">JV</th>
            <th rowspan="2" class="text-center">AX</th>
            <th rowspan="2" class="text-center">RH</th>
            <th rowspan="2" class="text-center">SMT</th>

            <th colspan="4" class="text-center">Conversion (second)</th>
        </tr>
        <tr>
            <th class="text-center">JV</th>
            <th class="text-center">AX</th>
            <th class="text-center">RH</th>
            <th class="text-center">SMT</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($period_arr as $period_val): 
            $total_insert_smt = $total_jv = $total_ax = $total_rh = 0;

            foreach ($tmp_total_insert as $smt_total_insert) {
                if ($smt_total_insert->end_job_period == $period_val && $smt_total_insert->child_analyst == 'WM03') {
                    $total_insert_smt = $smt_total_insert->TOTAL_INSERT_POINT;
                }
            }

            foreach ($tmp_total_insert as $ai_total_insert) {
                if ($ai_total_insert->end_job_period == $period_val && $ai_total_insert->child_analyst == 'WM02') {
                    $total_jv = $ai_total_insert->TOTAL_JV;
                    $total_ax = $ai_total_insert->TOTAL_AX;
                    $total_rh = $ai_total_insert->TOTAL_RH;
                }
            }
            ?>
            <tr>
                <td class="text-center"><?= date('M\' y', strtotime($period_val . '01')); ?></td>
                <td class="text-center">
                    <?= number_format($total_jv); ?>
                </td>
                <td class="text-center">
                    <?= number_format($total_ax); ?>
                </td>
                <td class="text-center">
                    <?= number_format($total_rh); ?>
                </td>
                <td class="text-center">
                    <?php
                    echo number_format($total_insert_smt);
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    $total_jv_conversion = $total_jv * 0.75;
                    echo number_format($total_jv_conversion);
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    $total_ax_conversion = $total_ax * 0.2;
                    echo number_format($total_ax_conversion);
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    $total_rh_conversion = $total_rh * 0.4;
                    echo number_format($total_rh_conversion);
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    $total_insert_smt_conversion = $total_insert_smt * 0.21;
                    echo number_format($total_insert_smt_conversion);
                    ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php ActiveForm::end(); ?>