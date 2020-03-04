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

/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div class="row">
    <?php foreach ($server_status as $key => $value): ?>
        <?php
        $tmp_data_memory = $data_memory = [];
        $tmp_data_memory = [
            [
                'name' => 'Used',
                'y' => $value->memory_used,
                'color' => new JsExpression('Highcharts.getOptions().colors[8]'),
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
                'color' => new JsExpression('Highcharts.getOptions().colors[8]'),
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
                'color' => new JsExpression('Highcharts.getOptions().colors[8]'),
            ],
            [
                'name' => 'Free',
                'y' => $value->d_driveinfo_freeSpace,
                'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
            ],
        ];
        $data_d = [
            [
                'name' => 'Drive C Usage',
                'data' => $tmp_data_d
            ]
        ];
        ?>
        <div class="col-md-2">
            <div class="text-center" style="color: white; font-size: 2em;"><?= $value->server_name; ?></div>
            <br/>
            <div class="box box-primary box-solid">
                <div class="box-header text-center">
                    <h3 class="box-title">Memory Usage</h3>
                </div>
                <div class="box-body">
                    <?=
                    Highcharts::widget([
                        'scripts' => [
                            //'modules/exporting',
                            //'themes/sand-signika',
                            'highcharts-more',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'pie',
                                'height' => 150,
                                'style' => [
                                    'fontFamily' => 'sans-serif',
                                ],
                                'options3d' => [
                                    'enabled' => trus,
                                    'alpha' => 45,
                                    'beta' => 0
                                ],
                                'plotBackgroundColor' => null,
                                'plotBackgroundImage' => null,
                                'plotBorderWidth' => null,
                                'plotShadow' => false,
                            ],
                            'title' => [
                                'text' => null
                            ],
                            'credits' => [
                                'enabled' =>false
                            ],
                            'tooltip' => [
                                'pointFormat' => '{series.name}: <b>{point.percentage:.2f}%</b>'
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'depth' => 35,
                                    'dataLabels' => [
                                        'enabled' => false,
                                        'format' => '{point.name}'
                                    ]
                                ],
                            ],
                            'series' => $data_memory
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="box box-info box-solid">
                <div class="box-header text-center">
                    <h3 class="box-title">Drive C</h3>
                </div>
                <div class="box-body">
                    <?=
                    Highcharts::widget([
                        'scripts' => [
                            //'modules/exporting',
                            //'themes/sand-signika',
                            'highcharts-more',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'pie',
                                'height' => 150,
                                'style' => [
                                    'fontFamily' => 'sans-serif',
                                ],
                                'options3d' => [
                                    'enabled' => trus,
                                    'alpha' => 45,
                                    'beta' => 0
                                ],
                                'plotBackgroundColor' => null,
                                'plotBackgroundImage' => null,
                                'plotBorderWidth' => null,
                                'plotShadow' => false,
                            ],
                            'title' => [
                                'text' => null
                            ],
                            'credits' => [
                                'enabled' =>false
                            ],
                            'tooltip' => [
                                'pointFormat' => '{series.name}: <b>{point.percentage:.2f}%</b>'
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'depth' => 35,
                                    'dataLabels' => [
                                        'enabled' => false,
                                        'format' => '{point.name}'
                                    ]
                                ],
                            ],
                            'series' => $data_c
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="box box-success box-solid">
                <div class="box-header text-center">
                    <h3 class="box-title">Drive D</h3>
                </div>
                <div class="box-body">
                    <?=
                    Highcharts::widget([
                        'scripts' => [
                            //'modules/exporting',
                            //'themes/sand-signika',
                            'highcharts-more',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'pie',
                                'height' => 150,
                                'style' => [
                                    'fontFamily' => 'sans-serif',
                                ],
                                'options3d' => [
                                    'enabled' => trus,
                                    'alpha' => 45,
                                    'beta' => 0
                                ],
                                'plotBackgroundColor' => null,
                                'plotBackgroundImage' => null,
                                'plotBorderWidth' => null,
                                'plotShadow' => false,
                            ],
                            'title' => [
                                'text' => null
                            ],
                            'credits' => [
                                'enabled' =>false
                            ],
                            'tooltip' => [
                                'pointFormat' => '{series.name}: <b>{point.percentage:.2f}%</b>'
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'depth' => 35,
                                    'dataLabels' => [
                                        'enabled' => false,
                                        'format' => '{point.name}'
                                    ]
                                ],
                            ],
                            'series' => $data_d
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
