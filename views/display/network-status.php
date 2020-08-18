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
    'page_title' => 'Network Status',
    'tab_title' => 'Network Status',
    'breadcrumbs_title' => 'Network Status'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
/*
$this->registerCssFile('@web/css/component.css');
$this->registerJsFile('@web/js/snap.svg-min.js');
$this->registerJsFile('@web/js/classie.js');
$this->registerJsFile('@web/js/svgLoader.js');*/

$this->registerCss("
    .control-label {color: white;}
    .content-header {color: white; text-align: center; display: none;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5; font-family: Arial, Helvetica, sans-serif; line-height: unset;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .form-horizontal .control-label {padding-top: 0px;}
    .border-white {border: 1px solid white;}
    .widget-header {border: 1px solid grey; padding: 10px; font-size: 3em; letter-spacing: 1.5px; color: white;}
    .widget-content {border: 1px solid grey; font-size: 3em; height: 400px; color: black;}
");

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

/*$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['network-status-data', 'no' => $no]) . "',
            success: function(data){
                var tmp_data = JSON.parse(data);
                //$('#speed').html(tmp_data.reply_roundtriptime);
                //$('#bg-mbps').attr('class', 'widget-content ' + tmp_data.bg_reply_time);
            },
            complete: function(){
                setTimeout(function(){update_data();}, 1000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
    });
");*/

/*$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#myTable').DataTable({
        'pageLength': 15,
        'order': [[ 0, 'desc' ]]
    });
});");*/

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div class="row" style="padding: 0px 20px;">
    <div class="col-md-12 text-center" style="background-color: rgba(255, 255, 255, 0.05); border: 2px solid grey; border-radius: 20px 20px 0px 0px;">
        <span style="font-size: 18em; color: white;">
            <?= $title; ?>
        </span>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="padding: 20px 20px 0px 20px;">
        <div class="widget-header text-center">
            <span>REPLY ROUND TRIP TIME (ms)</span>
        </div>
    </div>
</div>
<div class="row" style="padding: 0px 20px;">
    <div class="col-md-5 text-center" style="padding: 0px;">
        <div id="bg-mbps" class="widget-content <?= $bg_reply_time; ?>">
            <div style="font-size: 250px; line-height: 400px; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, 1px -1px 0 #000, 1px -1px 0 #000;" id="speed"><?= $reply_time ?></div><br/>
        </div>
    </div>
    <div class="col-md-7 text-center" style="padding: 0px;">
        <div class="widget-content">
            <div style="margin-top: 15px;">
                <?=
                Highcharts::widget([
                    'scripts' => [
                        'highcharts-more',
                        //'modules/exporting',
                        //'themes/sand-signika',
                        'modules/solid-gauge',
                        //'themes/dark-unica',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'spline',
                            'height' => '380',
                            'backgroundColor' => '#000',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'marginRight' => 10,
                            'events' => [
                                'load' => new JsExpression("function () {
                                    // set up the updating of the chart each second
                                    var series = this.series[0];
                                    setInterval(function () {
                                        $.getJSON('" . Url::to(['display/network-status-data', 'no' => $no]) . "', function (jsondata) {
                                            var x = (new Date()).getTime(), // current time
                                            y = jsondata.reply_roundtriptime;
                                            if(y <= 100){
                                                series.addPoint({x: x, y: y, color: 'green'}, true, true);
                                            } else if (y <= 120){
                                                series.addPoint({x: x, y: y, color: 'orange'}, true, true);
                                            } else {
                                                series.addPoint({x: x, y: y, color: 'red'}, true, true);
                                            }
                                            $('#speed').html(jsondata.reply_roundtriptime);
                                            $('#bg-mbps').attr('class', 'widget-content ' + jsondata.bg_reply_time);
                                        });
                                    }, 2000);
                                }"),
                            ],
                        ],
                        'time' => [
                            'useUTC' => false
                        ],
                        'title' => [
                            'text' => null,
                            'style' => [
                                'color' => 'white'
                            ],
                        ],
                        'accessibility' => [
                            'announceNewData' => [
                                'enabled' => true,
                                'minAnnounceInterval' => 15000,
                                'announcementFormatter' => new JsExpression("function (allSeries, newSeries, newPoint) {
                                    if (newPoint) {
                                        return 'New point added. Value: ' + newPoint.y;
                                    }
                                    return false;
                                }"),
                            ],
                        ],
                        'xAxis' => [
                            'type' => 'datetime',
                            'tickPixelInterval' => 150,
                            'lineWidth' => 1,
                            'gridLineColor' => '#1b1b1b',
                            // 'plotLines' => [
                            //     'color' => '#FF0000'
                            // ],
                            //'visible' => false
                        ],
                        'yAxis' => [
                            'gridLineColor' => '#1b1b1b',
                            'minorGridLineWidth' => 0,
                            'title' => [
                                'enabled' => false
                            ],
                            'plotLines' => [
                                [
                                    'value' => 0,
                                    'width' => 1,
                                    'color' => '#808080'
                                ]
                            ],
                            'allowDecimals' => false,
                            'max' => 130,
                            'min' => 10,
                            'tickInterval' => 10
                        ],
                        'tooltip' => [
                            'headerFormat' => '<b>{series.name}</b><br/>',
                            'pointFormat' => '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y:.2f}'
                        ],
                        'legend' => [
                            'enabled' => false
                        ],
                        'credits' => [
                            'enabled' => false
                        ],
                        'exporting' => [
                            'enabled' => false
                        ],
                        'plotOptions' => [
                            'spline' => [
                                'marker' => [
                                    'radius' => 4
                                ],
                            ],
                            
                        ],
                        'series' => [
                            [
                                'name' => 'Reply Round Trip Time',
                                'data' => new JsExpression("(function () {
                                    // generate an array of random data
                                    var data = [], rnd,
                                        time = (new Date()).getTime(),
                                        i;

                                    for (i = -39; i <= 0; i += 1) {
                                        rnd = null;
                                        if(rnd > 0.75){
                                            data.push({
                                                x: time + i * 1000,
                                                y: rnd,
                                                color: 'red'
                                            });
                                        } else {
                                            data.push({
                                                x: time + i * 1000,
                                                y: rnd,
                                            });
                                        }
                                        
                                    }
                                    return data;
                                }())"),
                                'color' => 'white'
                            ],
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>