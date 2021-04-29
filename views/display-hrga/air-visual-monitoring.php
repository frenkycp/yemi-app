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
    'page_title' => 'Air Visual Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Air Visual Monitoring',
    'breadcrumbs_title' => 'Air Visual Monitoring'
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

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid black;
        background-color: #7d5685;
        color: white;
        font-size: 20px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .summary-tbl > tbody > tr > td{
        border: 1px solid black;
        font-size: 16px;
        background: #8bd78f;
        color: #000;
        vertical-align: middle;
        //padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
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
    .side-title {
        font-size: 26px;
        color: white;
        letter-spacing: 2px;
        font-weight : bold;
    }
    .temp-over-style {
        background-color: red;
        color: white;
    }
    .panel-title {
        font-size: 30px;
    }
    .text-yellow {
        color: yellow !important;
        font-weight: bold;
        letter-spacing: 2px;
    }
    //tbody > tr > td { background: #33383d;}
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 30000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    $(document).ready(function() {
        var i = 0;
        setInterval(function() {
            i++;
            if(i%2 == 0){
                $(".temp-over").css("background-color", "red");
                $(".temp-over").css("color", "white");
            } else {
                $(".temp-over").css("background-color", "#8bd78f");
                $(".temp-over").css("color", "black");
            }
        }, 700);
    });
JS;
$this->registerJs($script, View::POS_END );


/*echo '<pre>';
print_r($tmp_belum_check);
echo '</pre>';*/
?>
<br/>
<div class="row">
    <?php foreach ($data as $key => $value): ?>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading text-center bg-navy-active">
                    <h3 class="panel-title"><?= $value->loc; ?></h3>
                </div>
                <div class="panel-body bg-black text-center">
                    <div class="row" style="font-size: 50px; color: white;"><span class="text-yellow"><?= $value->co2_ppm; ?></span> <small style="font-size: 0.7em;">ppm</small></div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            echo Highcharts::widget([
                                'scripts' => [
                                    //'modules/exporting',
                                    //'themes/sand-signika',
                                    'themes/dark-unica',
                                ],
                                'options' => [
                                    'chart' => [
                                        'type' => 'line',
                                        'style' => [
                                            'fontFamily' => 'sans-serif',
                                        ],
                                        'height' => 300,
                                        'backgroundColor' => '#000',
                                    ],
                                    'title' => [
                                        'text' => null
                                    ],
                                    'subtitle' => [
                                        'text' => ''
                                    ],
                                    'xAxis' => [
                                        'type' => 'datetime',
                                        //'categories' => $value['category'],
                                    ],
                                    'yAxis' => [
                                        /*'stackLabels' => [
                                            'enabled' => true
                                        ],*/
                                        'min' => 400,
                                        'max' => 1100,
                                        'title' => [
                                            'text' => 'CO2 Rate'
                                        ],
                                        'allowDecimals' => false,
                                        'tickInterval' => 100,
                                        'plotBands' => [
                                            [
                                                'from' => 400,
                                                'to' => 800,
                                                'color' => '#56FF5F',
                                            ],
                                            [
                                                'from' => 800,
                                                'to' => 1000,
                                                'color' => '#FBBB02',
                                            ],
                                            [
                                                'from' => 1000,
                                                'to' => 2000,
                                                'color' => '#EC4444',
                                            ],
                                        ],
                                        //'gridLineWidth' => 0,
                                    ],
                                    'credits' => [
                                        'enabled' =>false
                                    ],
                                    'tooltip' => [
                                        'enabled' => true,
                                        //'xDateFormat' => '%A, %b %e %Y',
                                        //'valueSuffix' => ' min'
                                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                                    ],
                                    'plotOptions' => [
                                        'line' => [
                                            //'stacking' => 'normal',
                                            'dataLabels' => [
                                                'enabled' => false,
                                                //'format' => '{point.percentage:.0f}% ({point.qty:.0f})',
                                                //'color' => 'black',
                                                //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                                /*'style' => [
                                                    'textOutline' => '0px',
                                                    'fontWeight' => '0'
                                                ],*/
                                            ],
                                            //'borderWidth' => 1,
                                            //'borderColor' => $color,
                                        ],
                                        'series' => [
                                            'lineWidth' => 3
                                        ],
                                    ],
                                    'series' => $data_log[$value->deviceno]
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <?php endforeach ?>
</div>
