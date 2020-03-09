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
    body {background-color: #ecf0f5;}
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
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 60000); // milliseconds
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
                        $('#header_' + index).attr('class', 'bg-green')
                    } else {
                        $('#timer_' + index).css('display', '');
                        $('#usage_' + index).css('display', 'none');
                        $('#header_' + index).attr('class', 'bg-red')
                    }
                });
            },
            complete: function(){
                setTimeout(function(){update_data();}, 5000);
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
    '172.17.144.65' => 'MITA - DATABASE',
    '172.17.144.5' => 'WSUS',
    '172.17.144.211' => 'BEA CUKAI',
    '174.17.144.109' => 'IOT MACHINE',
    '172.17.144.6' => 'MITA - APPLICATION',
];
?>
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
            <div id="header_<?= $value->server_mac_address; ?>" class="<?= $value->server_on_off == 'ON-LINE' ? ' bg-green' : ' bg-red'; ?>" style="border: 1px solid white; border-radius: 10px 10px 0px 0px; font-size: 2em; padding-left: 10px;">
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
                                                }, 5000);}"),
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
                                                'format' => '<div style="text-align:center; color: white;"><span style="font-size:22px; letter-spacing: 1.5px;">{y}</span><span style="font-size:19px;opacity:0.6">%</span></div>'
                                            ],
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
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
