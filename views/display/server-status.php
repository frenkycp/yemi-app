<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

$this->title = [
    'page_title' => 'Server Status <span class="japanesse light-green"></span>',
    'tab_title' => 'Server Status',
    'breadcrumbs_title' => 'Server Status'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white; display: none;}
    //.box-body {background-color: #000;}
    // .box-title {font-weight: bold;}
    // .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5; font-family: Arial, Helvetica, sans-serif;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}

    #progress-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #progress-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #595F66;
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #progress-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 28px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
    }
    .bg-green {background-color: #006400 !important;}
    .bg-red {background-color: #8B0000 !important;}
    .text-red, .text-green {text-shadow: -2px -2px 0 #FFF, 2px -2px 0 #FFF, -2px 2px 0 #FFF, 2px 2px 0 #FFF;}
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
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
            url: '" . Url::to(['server-status-online']) . "',
            success: function(data){
                $.each(data.server_data_arr , function(index, val) {
                    $('#timer_' + index).html(val.timer_txt);
                    if(val.status == 'ON-LINE'){
                        $('#timer_' + index).css('display', 'none');
                        $('#usage_' + index).css('display', '');
                        $('#header_' + index).attr('class', 'text-green')
                    } else {
                        $('#timer_' + index).css('display', '');
                        $('#usage_' + index).css('display', 'none');
                        $('#header_' + index).attr('class', 'text-red')
                    }
                });
            },
            complete: function(){
                setTimeout(function(){update_data();}, 1000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
    });
");

/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;

$server_arr = [
    '172.17.144.65' => 'MITA - DB',
    '172.17.144.5' => 'WSUS',
    '172.17.144.6' => 'MITA - APP',
    '174.17.144.109' => 'IoT',
    '172.17.144.211' => 'IT INVENTORY',
];
?>
<div class="text-center" style="border-bottom: 1px solid grey; display: none;">
    <span class="" style="color: white; font-size: 5em; letter-spacing: 3px;">SERVER STATUS</span>
</div>
<br/>
<div class="row">
    <?php foreach ($server_status as $key => $value): ?>
        <?php
        $tmp_data_memory = $data_memory = [];
        $tmp_data_memory = [
            [
                'name' => 'Used',
                'y' => $value->memory_used,
                'color' => new JsExpression('Highcharts.getOptions().colors[0]'),
            ],
            [
                'name' => 'Free',
                'y' => $value->memory_free,
                'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
            ],
        ];
        $data_memory = [
            [
                'name' => 'Memory Usage',
                'data' => $tmp_data_memory
            ]
        ];

        $tmp_data_c = $data_c = [];
        $tmp_data_c = [
            [
                'name' => 'Used',
                'y' => $value->c_driveinfo_used,
                'color' => new JsExpression('Highcharts.getOptions().colors[0]'),
            ],
            [
                'name' => 'Free',
                'y' => $value->c_driveinfo_freeSpace,
                'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
            ],
        ];
        $data_c = [
            [
                'name' => 'Drive C Usage',
                'data' => $tmp_data_c
            ]
        ];

        $tmp_data_d = $data_d = [];
        $tmp_data_d = [
            [
                'name' => 'Used',
                'y' => $value->d_driveinfo_used,
                'color' => new JsExpression('Highcharts.getOptions().colors[0]'),
            ],
            [
                'name' => 'Free',
                'y' => $value->d_driveinfo_freeSpace,
                'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
            ],
        ];
        $data_d = [
            [
                'name' => 'Drive D Usage',
                'data' => $tmp_data_d
            ]
        ];
        ?>
        <div class="col-md-6 text-center" style="margin-bottom: 20px;">
            <div id="header_<?= $value->server_mac_address; ?>" class="<?= $value->server_on_off == 'ON-LINE' ? ' text-green' : ' text-red'; ?>" style="border: 1px solid white; border-radius: 10px 10px 0px 0px; font-size: 6em; padding-left: 10px; letter-spacing: 10px; font-weight: bold;">
                <?= isset($server_arr[$value->server_ip]) ? $server_arr[$value->server_ip] : $value->server_name; ?>
            </div>
            
            <div style="border: 1px solid white; min-height: 221px; border-radius: 0px 0px 10px 10px; border-top: unset;">
                <div class="text-center" style="width: 100%; padding: 10px;">
                    <div id="usage_<?= $value->server_mac_address; ?>" class="row" style="<?= $value->server_on_off == 'ON-LINE' ? '' : 'display: none;'; ?>">
                        <div class="col-md-4">
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
                                        'type' => 'solidgauge',
                                        'height' => '200',
                                        'backgroundColor' => '#000',
                                        'style' => [
                                            'fontFamily' => 'sans-serif',
                                        ],
                                        'events' => [
                                            'load' => new JsExpression("function () {
                                                var series = this.series[0].points[0];
                                                setInterval(function () {
                                                    $.getJSON('" . Url::to(['display/server-status-data', 'mac_address' => $value->server_mac_address]) . "', function (jsondata) {
                                                        //series.data = JSON.parse(jsondata.memory_usage);
                                                        series.update(jsondata.memory_usage);
                                                        //alert(series.data);
                                                    });
                                                }, 3000);}"),
                                        ],
                                    ],
                                    'title' => null,
                                    'pane' => [
                                        'center' => ['50%', '85%'],
                                        'size' => '130%',
                                        'startAngle' => -90,
                                        'endAngle' => 90,
                                        'background' => [

                                            'innerRadius' => '60%',
                                            'outerRadius' => '100%',
                                            'shape' => 'arc'
                                        ]
                                    ],
                                    'exporting' => [
                                        'enabled' =>false
                                    ],
                                    'credits' => [
                                        'enabled' =>false
                                    ],
                                    'tooltip' => [
                                        'enabled' => false,
                                    ],
                                    'yAxis' => [
                                        'stops' => [
                                            [0.1, '#55BF3B'], // green
                                            [0.5, '#DDDF0D'], // yellow
                                            [0.9, '#DF5353'] // red
                                        ],
                                        'lineWidth' => 0,
                                        'tickWidth' => 0,
                                        'minorTickInterval' => null,
                                        'tickAmount' => 2,
                                        'title' => [
                                            'text' => 'Memory Usage',
                                            'y' => -75,
                                            'style' => [
                                                'color' => 'white',
                                                'letter-spacing' => '2px'
                                            ]
                                        ],
                                        'labels' => [
                                            'y' => 16,
                                            'style' => [
                                                'color' => 'white'
                                            ]
                                        ],
                                        'min' => 0,
                                        'max' => 100,
                                    ],
                                    'plotOptions' => [
                                        'solidgauge' => [
                                            'dataLabels' => [
                                                'y' => 5,
                                                'borderWidth' => 0,
                                                'useHTML' => true
                                            ]
                                        ],
                                    ],
                                    'series' => [
                                        [
                                            'name' => 'Memory Usage',
                                            'data' => [($value->memory_used)],
                                            'tooltip' => [
                                                'valueSuffix' => ' %',
                                            ],
                                            'dataLabels' => [
                                                'format' => '<div style="text-align:center; color: white;"><span style="font-size:22px; letter-spacing: 1.5px;">{point.y:.1f}</span><span style="font-size:19px;opacity:0.6">%</span></div>'
                                            ],
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-8">
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
                                        'height' => '200',
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
                                                    $.getJSON('" . Url::to(['display/server-status-data', 'mac_address' => $value->server_mac_address]) . "', function (jsondata) {
                                                        var x = (new Date()).getTime(), // current time
                                                        y = jsondata.ping;
                                                        if(y > 100){
                                                            series.addPoint({x: x, y: y, color: 'red'}, true, true);
                                                        } else {
                                                            series.addPoint({x: x, y: y, color: 'green'}, true, true);
                                                        }
                                                    });
                                                }, 3000);
                                            }"),
                                        ],
                                    ],
                                    'time' => [
                                        'useUTC' => false
                                    ],
                                    'title' => [
                                        'text' => 'Reply Round Trip Time',
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
                                        'max' => 20,
                                        'tickInterval' => 5
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
                                                'radius' => 2
                                            ],
                                        ],
                                        
                                    ],
                                    'series' => [
                                        [
                                            'name' => 'Random Data',
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
                                                            y: rnd
                                                        });
                                                    }
                                                    
                                                }
                                                return data;
                                            }())"),
                                            'color' => 'white',
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-4" style="display: none;">
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
                                        'type' => 'solidgauge',
                                        'height' => '200',
                                        'backgroundColor' => '#000',
                                        'style' => [
                                            'fontFamily' => 'sans-serif',
                                        ],
                                    ],
                                    'title' => null,
                                    'pane' => [
                                        'center' => ['50%', '85%'],
                                        'size' => '130%',
                                        'startAngle' => -90,
                                        'endAngle' => 90,
                                        'background' => [

                                            'innerRadius' => '60%',
                                            'outerRadius' => '100%',
                                            'shape' => 'arc'
                                        ]
                                    ],
                                    'exporting' => [
                                        'enabled' =>false
                                    ],
                                    'credits' => [
                                        'enabled' =>false
                                    ],
                                    'tooltip' => [
                                        'enabled' => false,
                                    ],
                                    'yAxis' => [
                                        'stops' => [
                                            [0.1, '#55BF3B'], // green
                                            [0.5, '#DDDF0D'], // yellow
                                            [0.9, '#DF5353'] // red
                                        ],
                                        'lineWidth' => 0,
                                        'tickWidth' => 0,
                                        'minorTickInterval' => null,
                                        'tickAmount' => 2,
                                        'title' => [
                                            'text' => 'Drive Usage (C:)',
                                            'y' => -75,
                                            'style' => [
                                                'color' => 'white',
                                                'letter-spacing' => '2px'
                                            ]
                                        ],
                                        'labels' => [
                                            'y' => 16,
                                            'style' => [
                                                'color' => 'white'
                                            ]
                                        ],
                                        'min' => 0,
                                        'max' => 100,
                                    ],
                                    'plotOptions' => [
                                        'solidgauge' => [
                                            'dataLabels' => [
                                                'y' => 5,
                                                'borderWidth' => 0,
                                                'useHTML' => true
                                            ]
                                        ],
                                    ],
                                    'series' => [
                                        [
                                            'name' => 'Drive Usage (C:)',
                                            'data' => [round($value->c_driveinfo_used_pct)],
                                            'tooltip' => [
                                                'valueSuffix' => ' %',
                                            ],
                                            'dataLabels' => [
                                                'format' => '<div style="text-align:center; color: white;"><span style="font-size:22px; letter-spacing: 1.5px;">{y}</span><span style="font-size:19px;opacity:0.6">%</span></div>'
                                            ],
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-4" style="display: none;">
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
                                        'type' => 'solidgauge',
                                        'height' => '200',
                                        'backgroundColor' => '#000',
                                        'style' => [
                                            'fontFamily' => 'sans-serif',
                                        ],
                                    ],
                                    'title' => null,
                                    'pane' => [
                                        'center' => ['50%', '85%'],
                                        'size' => '130%',
                                        'startAngle' => -90,
                                        'endAngle' => 90,
                                        'background' => [

                                            'innerRadius' => '60%',
                                            'outerRadius' => '100%',
                                            'shape' => 'arc'
                                        ]
                                    ],
                                    'exporting' => [
                                        'enabled' =>false
                                    ],
                                    'credits' => [
                                        'enabled' =>false
                                    ],
                                    'tooltip' => [
                                        'enabled' => false,
                                    ],
                                    'yAxis' => [
                                        'stops' => [
                                            [0.1, '#55BF3B'], // green
                                            [0.5, '#DDDF0D'], // yellow
                                            [0.9, '#DF5353'] // red
                                        ],
                                        'lineWidth' => 0,
                                        'tickWidth' => 0,
                                        'minorTickInterval' => null,
                                        'tickAmount' => 2,
                                        'title' => [
                                            'text' => 'Drive Usage (D:)',
                                            'y' => -75,
                                            'style' => [
                                                'color' => 'white',
                                                'letter-spacing' => '2px'
                                            ]
                                        ],
                                        'labels' => [
                                            'y' => 16,
                                            'style' => [
                                                'color' => 'white'
                                            ]
                                        ],
                                        'min' => 0,
                                        'max' => 100,
                                    ],
                                    'plotOptions' => [
                                        'solidgauge' => [
                                            'dataLabels' => [
                                                'y' => 5,
                                                'borderWidth' => 0,
                                                'useHTML' => true
                                            ]
                                        ],
                                    ],
                                    'series' => [
                                        [
                                            'name' => 'Drive Usage (D:)',
                                            'data' => [round($value->d_driveinfo_used_pct)],
                                            'tooltip' => [
                                                'valueSuffix' => ' %',
                                            ],
                                            'dataLabels' => [
                                                'format' => '<div style="text-align:center; color: white;"><span style="font-size:22px; letter-spacing: 1.5px;">{y}</span><span style="font-size:19px;opacity:0.6">%</span></div>'
                                            ],
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div id="timer_<?= $value->server_mac_address; ?>" class="row" style="font-size: 7em; line-height: 195px; color: red; text-shadow: -1px -1px 0 #FFF, 1px -1px 0 #FFF, -1px 1px 0 #FFF, 1px 1px 0 #FFF; letter-spacing: 4px;">
                        
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
