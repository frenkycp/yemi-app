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
    'page_title' => 'YEMI POWER CONSUMPTION <span class="japanesse light-green"></span>',
    'tab_title' => 'YEMI POWER CONSUMPTION',
    'breadcrumbs_title' => 'YEMI POWER CONSUMPTION'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 1em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .chart-header {
        border: 2px solid white;
        border-radius: 10px 10px 0px 0px;
        font-size: 2em;
        padding-left: 10px;
        letter-spacing: 5px;
        color: white;
        background-color: rgba(0, 120, 0, 0.25);
    }
    .chart-content {
        border: 2px solid white;
        min-height: 221px;
        border-radius: 0px 0px 10px 10px;
        border-top: unset;
    }
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

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['power-consumption-dashboard']),
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

<?php foreach ($power_consumption_current as $current): ?>
    <div class="chart-header">
        <span><?= $current->area; ?></span>
    </div>
    <div class="chart-content">
        <div class="row">
            <div class="col-md-3">
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
                            'height' => '210',
                            'backgroundColor' => '#000',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'events' => [
                                'load' => new JsExpression("function () {
                                    var series = this.series[0].points[0];
                                    setInterval(function () {
                                        $.getJSON('" . Url::to(['display/power-consumption-data', 'map_no' => $current->map_no]) . "', function (jsondata) {
                                            //series.data = JSON.parse(jsondata.memory_usage);
                                            series.update(jsondata.power_consumption);
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
                                'text' => 'Power Consumption',
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
                                'name' => 'Power Consumption',
                                'data' => [round($current->power_consumption, 1)],
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
            <div class="col-md-9">
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
                        ],
                        'time' => [
                            'useUTC' => false
                        ],
                        'title' => [
                            'text' => 'Average Power Consumption (kwH)',
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
                            'max' => 100,
                            'min' => 0,
                            'tickInterval' => 5
                        ],
                        /*'tooltip' => [
                            'headerFormat' => '<b>{series.name}</b><br/>',
                            'pointFormat' => '{point.x:%Y-%m-%d %H:%M:%S}<br/>{point.y:.2f}'
                        ],*/
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
                        'series' => $avg_data[$current->map_no]
                    ],
                ]);
                ?>
            </div>
        </div>
    </div><br/>
<?php endforeach ?>
