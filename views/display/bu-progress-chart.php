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
    'page_title' => 'PRODUCTION PROGRESS <span class="japanesse light-green">(生産進捗)</span> VMS (D-1)',
    'tab_title' => 'PRODUCTION PROGRESS (D-1)',
    'breadcrumbs_title' => 'PRODUCTION PROGRESS (D-1)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 1em; text-align: center;}
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
        font-size: 50px;
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
        font-size: 40px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
        padding: 0px 10px;
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
        font-size: 50px;
        background: #000;
        color: white;
        vertical-align: middle;
        padding: 10px 10px;
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
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
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

/*$script = "
    $('document').ready(function() {
        $('#popup-tbl').DataTable({
            'order': [[ 6, 'desc' ]]
        });
    });
";
$this->registerJs($script, View::POS_HEAD );*/

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
//echo $period;
// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_top_minus);
echo '</pre>';*/
?>
<div class="row" style="padding-top: 20px;">
    <div class="col-sm-12 text-center" style="color: white; font-size: 40px;">
        <?= strtoupper($period_text); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/dark-unica',
                //'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 850,
                    'style' => [
                        'fontFamily' => 'sans-serif'
                    ],
                    'backgroundColor' => 'black'
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => null
                ],
                'subtitle' => [
                    'text' => null
                ],
                'xAxis' => [
                    'categories' => $categories,
                    'labels' => [
                        'style' => [
                            'fontSize' => '60px'
                        ],
                    ],
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'PROGRESS (%)'
                    ],
                    'labels' => [
                        'style' => [
                            'fontSize' => '30px',
                        ],
                    ],
                    'max' => 100,
                ],
                'plotOptions' => [
                    'column' => [
                        'dataLabels' => [
                            'enabled' => true,
                            'style' => [
                                'fontSize' => '60px'
                            ],
                            'inside' => true,
                            'format' => '{y}%'
                        ]
                    ],
                    'series' => [
                        'pointPadding' => '0.1',
                        'groupPadding' => 0,
                    ],
                ],
                'series' => $data_chart
            ],
        ]);
        ?>
    </div>
</div>