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
    'page_title' => 'PT. YEMI Standard Time <span class="japanesse light-green"></span>',
    'tab_title' => 'PT. YEMI Standard Time',
    'breadcrumbs_title' => 'PT. YEMI Standard Time'
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
print_r($lt_non_prd);
echo '</pre>';*/

//echo Yii::$app->request->baseUrl;
?>
<span style="font-size: 2em; font-weight: bold;"><u>PT. YEMI Standard Time</u></span><br/>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['wip-standard-time']),
]); ?>

<div class="row">
    <div class="col-sm-2">
        <?= $form->field($model, 'fiscal_year')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
                'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
</div>
<br/>
<?php ActiveForm::end(); ?>
<span class="japanesse">加工工数（分）</span>
<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="text-center">PERIOD</th>
            <?php foreach ($tmp_wip_arr as $key => $value): ?>
                <th class="text-center"><?= $value; ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($std_data_arr as $period => $period_data): 
            $period_name = date('M\'Y', strtotime($period . '01'));
            ?>
            <tr>
                <td class="text-center"><?= $period; ?></td>
                <?php foreach ($tmp_wip_arr as $key => $value): ?>
                    <td class="text-center"><?= $period_data[$value] == null ? '-' : number_format($period_data[$value]); ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<span class="japanesse">除外時間 (分）</span>
<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="text-center">PERIOD</th>
            <?php foreach ($tmp_wip_arr as $key => $value): ?>
                <th class="text-center"><?= $value; ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lt_non_prd as $period => $period_data): 
            $period_name = date('M\'Y', strtotime($period . '01'));
            ?>
            <tr>
                <td class="text-center"><?= $period; ?></td>
                <?php foreach ($tmp_wip_arr as $key => $value): ?>
                    <td class="text-center"><?= $period_data[$value] == null ? '-' : number_format($period_data[$value]); ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<span class="japanesse">自宅待機時間 (分）</span>
<table class="table summary-tbl">
    <thead>
        <tr>
            <th class="text-center">PERIOD</th>
            <?php foreach ($tmp_wip_arr as $key => $value): ?>
                <th class="text-center"><?= $value; ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lt_isoman as $period => $period_data): 
            $period_name = date('M\'Y', strtotime($period . '01'));
            ?>
            <tr>
                <td class="text-center"><?= $period; ?></td>
                <?php foreach ($tmp_wip_arr as $key => $value): ?>
                    <td class="text-center"><?= $period_data[$value] == null ? '-' : number_format($period_data[$value]); ?></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>