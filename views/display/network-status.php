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

$this->registerCssFile('@web/css/component.css');
$this->registerJsFile('@web/js/snap.svg-min.js');
$this->registerJsFile('@web/js/classie.js');
$this->registerJsFile('@web/js/svgLoader.js');

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5; font-family: Arial, Helvetica, sans-serif; line-height: unset;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .form-horizontal .control-label {padding-top: 0px;}
    .border-white {border: 1px solid white;}
    .widget-header {border: 1px solid grey; margin: 0px 10px; padding: 10px; font-size: 3em; letter-spacing: 1.5px; color: white;}
    .widget-content {border: 1px solid grey; margin: 0px 10px; font-size: 3em; height: 400px; line-height: 400px; color: black;}
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 1800000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['network-status-data', 'no' => $no]) . "',
            success: function(data){
                var tmp_data = JSON.parse(data);
                $('#speed').html(tmp_data.speed_mbps);
                if(tmp_data.speed_mbps == 0){
                    $('#bg-title').attr('class', 'col-md-12 text-center speed-danger');
                } else {
                    if(tmp_data.speed_mbps < 3){
                        $('#bg-title').attr('class', 'col-md-12 text-center speed-warning');
                    } else {
                        $('#bg-title').attr('class', 'col-md-12 text-center speed-normal');
                    }
                }
                $('#bg-mbps').attr('class', 'widget-content ' + tmp_data.bg_class);
            },
            complete: function(){
                setTimeout(function(){update_data();}, 2000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
    });
");

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
        <span style="font-size: 25em; color: white;">
            <?= $title; ?>
        </span>
    </div>
</div>
<div class="row">
    <div class="col-md-4 text-center" style="padding: 10px 0px 10px 10px;">
        <div class="widget-header">
            <span>SPEED (Mbps)</span>
        </div>
        <div id="bg-mbps" class="widget-content <?= $bg_class; ?>">
            <div style="font-size: 8em; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, 1px -1px 0 #000, 1px -1px 0 #000;" id="speed"><?= $speed_mbps ?></div><br/>
        </div>
    </div>
    <div class="col-md-8 text-center" style="padding: 10px 10px 10px 0px;">
        <div class="widget-header">
            <span>REPLY ROUND TRIP TIME</span>
        </div>
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
                                            if(y > 100){
                                                series.addPoint({x: x, y: y, color: 'red'}, true, true);
                                            } else {
                                                series.addPoint({x: x, y: y, color: 'green'}, true, true);
                                            }
                                        });
                                    }, 1000);
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
                            'max' => 150,
                            'min' => 70,
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
                                    'radius' => 5
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
<div style="height: 97vh; display: none;">
    <div class="row" style="height: 100%; border: 1px solid grey;">
        <div class="col-md-7" style="height: 100%; text-align: center; vertical-align: middle;">
            <span style="color: white; font-size: <?= $no == 1 ? '50vh' : '20vh'; ?>; line-height: 97vh;"><?= $title; ?></span>
        </div>
        <div class="col-md-5 text-center" style="height: 100%; padding: 0px;">
            <div class="<?= $bg_class; ?>" style="height: 50%; color: white; border-width: 0px 0px 1px 1px; border-style: solid; border-color: grey;">
                <span style="line-height: 48vh; font-size: 15em;"><?= $speed_mbps; ?> <span style="font-size: 0.5em;">Mbps</span></span>
            </div>
            <div style="height: 50%; color: white; border-width: 0px 0px 0px 1px; border-style: solid; border-color: grey;">
                <span style="line-height: 48vh; font-size: 20em;"><?= $info; ?></span>
            </div>
        </div>
    </div>
</div>