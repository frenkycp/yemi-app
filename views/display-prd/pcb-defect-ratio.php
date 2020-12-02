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
    'page_title' => 'PCB Defect Ratio <span class="japanesse light-green"></span>',
    'tab_title' => 'PCB Defect Ratio',
    'breadcrumbs_title' => 'PCB Defect Ratio'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

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
    .badge {font-weight: normal;}

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
        letter-spacing: 0.5px;
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
    .period-title {
        width: 110px;
        min-width: 110px;
    }
    .row-title {
        font-weight: bold;
    }
    .row-title > small {
        font-weight: normal;
        font-style: italic;
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
    'action' => Url::to(['pcb-defect-ratio']),
]); ?>

<div class="row" style="padding-top: 10px;">
    <div class="col-md-2">
        <?= $form->field($model, 'fiscal_year')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
                'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<?php foreach ($tmp_data as $model_name => $period_data_arr): 
    $tmp_total_ppm_arr = [];
    $avg_output = $avg_defect_fa = $avg_defect_fct_ict = $avg_defect_mi = $avg_defect_ai = $avg_defect_smt = $avg_ppm_fa = $avg_ppm_fct_ict = 0;
    $total_defect_fa = $total_defect_fct_ict = $total_defect_mi = $total_defect_ai = $total_defect_smt = $total_ppm_fa = $total_ppm_fct_ict = $total_output = 0;
    ?>
    <div class="table-responsive">
        <table class="table summary-tbl" style="margin-bottom: 0px;">
        <thead>
            <tr>
                <th style="min-width: 230px;">PCB - <?= $model_name; ?> MODEL<?= isset($ppm_target_arr[$model_name]) ? ' => TARGET : ' . $ppm_target_arr[$model_name] . ' dppm' : ''; ?></th>
                <?php foreach ($period_data_arr as $period => $period_data): ?>
                    <th class="text-center period-title">
                        <?= strtoupper(date('M\'Y', strtotime($period . '01'))); ?>
                    </th>
                <?php endforeach ?>
                <th class="text-center period-title">AVG</th>
                <th class="text-center period-title">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="row-title">Part Output PCB <small>(pcs)</small></span></td>
                <?php
                $tmp_grandtotal = $tmp_count = 0;
                foreach ($period_data_arr as $period_data): 
                    if ($period_data['output'] > 0) {
                        $tmp_count++;
                        $tmp_grandtotal += $period_data['output'];
                    }
                    ?>
                    <td class="text-center">
                        <?= number_format($period_data['output']); ?>
                    </td>
                <?php endforeach; 
                $tmp_avg = 0;
                if ($tmp_count > 0) {
                    $tmp_avg = round($tmp_grandtotal / $tmp_count);
                }
                $avg_output = $tmp_avg;
                $total_output = $tmp_grandtotal;
                ?>
                <td class="text-center"><?= number_format($tmp_avg); ?></td>
                <td class="text-center"><?= number_format($tmp_grandtotal); ?></td>
            </tr>
            <tr>
                <td><span class="row-title">Part Defect AI <small>(pcs)</small></span></td>
                <?php
                $tmp_grandtotal = $tmp_count = 0;
                foreach ($period_data_arr as $period_data): 
                    if ($period_data['defect_ai'] > 0) {
                        $tmp_count++;
                        $tmp_grandtotal += $period_data['defect_ai'];
                    }
                    ?>
                    <td class="text-center">
                        <?= number_format($period_data['defect_ai']); ?>
                    </td>
                <?php endforeach; 
                $tmp_avg = 0;
                if ($tmp_count > 0) {
                    $tmp_avg = round($tmp_grandtotal / $tmp_count);
                }
                $avg_defect_ai = $tmp_avg;
                $total_defect_ai = $tmp_grandtotal;
                ?>
                <td class="text-center"><?= number_format($tmp_avg); ?></td>
                <td class="text-center"><?= number_format($tmp_grandtotal); ?></td>
            </tr>
            <tr>
                <td><span class="row-title">Part Defect SMT <small>(pcs)</small></span></td>
                <?php
                $tmp_grandtotal = $tmp_count = 0;
                foreach ($period_data_arr as $period_data): 
                    if ($period_data['defect_smt'] > 0) {
                        $tmp_count++;
                        $tmp_grandtotal += $period_data['defect_smt'];
                    }
                    ?>
                    <td class="text-center">
                        <?= number_format($period_data['defect_smt']); ?>
                    </td>
                <?php endforeach; 
                $tmp_avg = 0;
                if ($tmp_count > 0) {
                    $tmp_avg = round($tmp_grandtotal / $tmp_count);
                }
                $avg_defect_smt = $tmp_avg;
                $total_defect_smt = $tmp_grandtotal;
                ?>
                <td class="text-center"><?= number_format($tmp_avg); ?></td>
                <td class="text-center"><?= number_format($tmp_grandtotal); ?></td>
            </tr>
            <tr>
                <td><span class="row-title">Part Defect MI <small>(pcs)</small></span></td>
                <?php
                $tmp_grandtotal = $tmp_count = 0;
                foreach ($period_data_arr as $period_data): 
                    if ($period_data['defect_mi'] > 0) {
                        $tmp_count++;
                        $tmp_grandtotal += $period_data['defect_mi'];
                    }
                    ?>
                    <td class="text-center">
                        <?= number_format($period_data['defect_mi']); ?>
                    </td>
                <?php endforeach; 
                $tmp_avg = 0;
                if ($tmp_count > 0) {
                    $tmp_avg = round($tmp_grandtotal / $tmp_count);
                }
                $avg_defect_mi = $tmp_avg;
                $total_defect_mi = $tmp_grandtotal;
                ?>
                <td class="text-center"><?= number_format($tmp_avg); ?></td>
                <td class="text-center"><?= number_format($tmp_grandtotal); ?></td>
            </tr>
            <tr>
                <td><span class="row-title">AI <small>(ppm)</small></span></td>
                <?php
                $tmp_grandtotal = $tmp_count = 0;
                foreach ($period_data_arr as $period => $period_data):
                    $tmp_ppm = 0;
                    if ($period_data['output'] > 0) {
                        $tmp_ppm = round(($period_data['defect_ai'] / $period_data['output']) * 1000000, 2);
                    }
                    if ($tmp_ppm > 0) {
                        $tmp_count++;
                        $tmp_grandtotal += $tmp_ppm;
                    }
                    $tmp_total_ppm_arr[$period] += $tmp_ppm;
                    ?>
                    <td class="text-center">
                        <?= $tmp_ppm; ?>
                    </td>
                <?php endforeach; 
                $tmp_avg = 0;
                if ($tmp_count > 0) {
                    $tmp_avg = round($tmp_grandtotal / $tmp_count);
                }
                ?>
                <td class="text-center"><?= round(($avg_defect_ai / $avg_output) * 1000000, 2); ?></td>
                <td class="text-center"><?= round(($total_defect_ai / $total_output) * 1000000, 2); ?></td>
            </tr>
            <tr>
                <td><span class="row-title">SMT <small>(ppm)</small></span></td>
                <?php
                $tmp_grandtotal = $tmp_count = 0;
                foreach ($period_data_arr as $period => $period_data):
                    $tmp_ppm = 0;
                    if ($period_data['output'] > 0) {
                        $tmp_ppm = round(($period_data['defect_smt'] / $period_data['output']) * 1000000, 2);
                    }
                    if ($tmp_ppm > 0) {
                        $tmp_count++;
                        $tmp_grandtotal += $tmp_ppm;
                    }
                    $tmp_total_ppm_arr[$period] += $tmp_ppm;
                    ?>
                    <td class="text-center">
                        <?= $tmp_ppm; ?>
                    </td>
                <?php endforeach; 
                $tmp_avg = 0;
                if ($tmp_count > 0) {
                    $tmp_avg = round($tmp_grandtotal / $tmp_count);
                }
                ?>
                <td class="text-center"><?= round(($avg_defect_smt / $avg_output) * 1000000, 2); ?></td>
                <td class="text-center"><?= round(($total_defect_smt / $total_output) * 1000000, 2); ?></td>
            </tr>
            <tr>
                <td><span class="row-title">MI <small>(ppm)</small></span></td>
                <?php
                $tmp_grandtotal = $tmp_count = 0;
                foreach ($period_data_arr as $period => $period_data):
                    $tmp_ppm = 0;
                    if ($period_data['output'] > 0) {
                        $tmp_ppm = round(($period_data['defect_mi'] / $period_data['output']) * 1000000, 2);
                    }
                    if ($tmp_ppm > 0) {
                        $tmp_count++;
                        $tmp_grandtotal += $tmp_ppm;
                    }
                    $tmp_total_ppm_arr[$period] += $tmp_ppm;
                    ?>
                    <td class="text-center">
                        <?= $tmp_ppm; ?>
                    </td>
                <?php endforeach; 
                $tmp_avg = 0;
                if ($tmp_count > 0) {
                    $tmp_avg = round($tmp_grandtotal / $tmp_count);
                }
                ?>
                <td class="text-center"><?= round(($avg_defect_mi / $avg_output) * 1000000, 2); ?></td>
                <td class="text-center"><?= round(($total_defect_mi / $total_output) * 1000000, 2); ?></td>
            </tr>
            <tr>
                <td><span class="row-title">Total <small>(ppm)</small></span></td>
                <?php
                $tmp_grandtotal = $tmp_count = 0;
                foreach ($tmp_total_ppm_arr as $tmp_ppm):
                    /*$tmp_ppm = 0;
                    if ($period_data['output'] > 0) {
                        $tmp_ppm = round((($period_data['defect_fct_ict'] + $period_data['defect_fa']) / $period_data['output']) * 1000000, 2);
                    }*/
                    if ($tmp_ppm > 0) {
                        $tmp_count++;
                        $tmp_grandtotal += $tmp_ppm;
                    }
                    ?>
                    <td class="text-center">
                        <?= $tmp_ppm; ?>
                    </td>
                <?php endforeach; 
                $tmp_avg = 0;
                if ($tmp_count > 0) {
                    $tmp_avg = round($tmp_grandtotal / $tmp_count);
                }
                ?>
                <td class="text-center"><?= round(($avg_defect_ai / $avg_output) * 1000000, 2) + round(($avg_defect_smt / $avg_output) * 1000000, 2) + round(($avg_defect_mi / $avg_output) * 1000000, 2); ?></td>
                <td class="text-center"><?= round(($total_defect_ai / $total_output) * 1000000, 2) + round(($total_defect_smt / $total_output) * 1000000, 2) + round(($total_defect_mi / $total_output) * 1000000, 2); ?></td>
            </tr>
        </tbody>
    </table>
    </div>
    <br/>
<?php endforeach ?>