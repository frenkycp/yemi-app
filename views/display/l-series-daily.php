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
    'page_title' => null,
    'tab_title' => 'Production Lead Time L-Series',
    'breadcrumbs_title' => 'Production Lead Time L-Series'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
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
print_r($data_power_consumption);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<div class="box box-primary box-solid">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                    //'themes/dark-unica',
                    //'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'bar',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 800,
                        //'zoomType' => 'x'
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => null,
                    ],
                    'xAxis' => [
                        'categories' => $categories
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Days',
                        ]
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'valueSuffix' => ' days'
                    ],
                    'plotOptions' => [
                        'bar' => [
                            //'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => true,
                                //'format' => '{point.percentage:.1f}%',
                                //'format' => '{point.percentage:.0f}%',
                            ],
                        ],
                        'series' => [
                            'pointPadding' => 0.05,
                            'groupPadding' => 0,
                        ],
                    ],
                    'series' => $data,
                ],
            ]);

            ?>
        </div>
    </div>
</div>