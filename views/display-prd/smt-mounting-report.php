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
    'page_title' => 'SMT Mounting Report <span class="japanesse light-green"></span>',
    'tab_title' => 'SMT Mounting Report',
    'breadcrumbs_title' => 'SMT Mounting Report'
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

/*echo '<pre>';
print_r($period_arr);
echo '</pre>';*/

//echo Yii::$app->request->baseUrl;
?>
<span style="font-size: 2em; font-weight: bold;"><u>SMT Mounting Report (Monthly)</u></span><br/>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['smt-ai-insert-point']),
]); ?>

<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'fiscal_year')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
                'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="text-center">PERIOD</th>
            <th class="text-center">Loss Time<br/>(Planned Loss)<br/>E</th>
            <th class="text-center">Loss Time<br/>(Out Section)<br/>F</th>
            <th class="text-center">Working Time<br/>(G)</th>
            <th class="text-center">Total Point<br/>(H)</th>
            <th class="text-center">H / (G-E-F)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tmp_data as $period_val => $data_val): ?>
            <tr>
                <td class="text-center"><?= date('M\'Y', strtotime($period_val . '01')); ?></td>
                <td class="text-center"><?= number_format($data_val['planed_loss_minute']); ?></td>
                <td class="text-center"><?= number_format($data_val['out_section_minute']); ?></td>
                <td class="text-center"><?= number_format($data_val['working_time']); ?></td>
                <td class="text-center"><?= number_format($data_val['TOTAL_POINT_ALL']); ?></td>
                <td class="text-center"><?= number_format($data_val['ratio']); ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>