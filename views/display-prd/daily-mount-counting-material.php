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
    'page_title' => 'Daily SMT reel count times <span class="japanesse light-green">(SMTリールカウントの回数)</span>',
    'tab_title' => 'Daily SMT reel count times',
    'breadcrumbs_title' => 'Daily SMT reel count times'
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
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['daily-mount-counting-material']),
]); ?>

<div class="row" style="">
    <div class="col-md-4">
        <?php echo '<label class="control-label">Select date range</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'from_date',
            'attribute2' => 'to_date',
            'options' => ['placeholder' => 'Start date'],
            'options2' => ['placeholder' => 'End date'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="panel panel-default">
    <div class="panel-body no-padding">
        <?=
        Highcharts::widget([
            'scripts' => [
                'highcharts-more',
                //'modules/exporting',
                //'themes/sand-signika',
                'modules/solid-gauge',
                'themes/dark-unica',
                //'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => '500',
                    'backgroundColor' => '#000',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'zoomType' => 'x'
                ],
                'title' => [
                    'text' => null,
                ],
                'xAxis' => [
                    'type' => 'datetime',
                    'lineWidth' => 1,
                    'gridLineColor' => '#1b1b1b',
                ],
                'yAxis' => [
                    'gridLineColor' => '#1b1b1b',
                    'minorGridLineWidth' => 0,
                    'title' => [
                        'enabled' => false
                    ],
                    'allowDecimals' => false,
                    //'max' => 1500,
                    'min' => 0,
                    //'tickInterval' => 20
                ],
                'legend' => [
                    'enabled' => false
                ],
                'credits' => [
                    'enabled' => false
                ],
                'plotOptions' => [
                    'column' => [
                        'maxPointWidth' => 50,
                        'dataLabels' => [
                            'enabled' => true,
                        ],
                    ],
                    
                ],
                'series' => $data,
            ],
        ]);
        ?>
    </div>
</div>