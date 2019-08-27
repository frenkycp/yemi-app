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
    'page_title' => 'LOT FLOW PROCESS <span class="japanesse text-green"></span>',
    'tab_title' => 'LOT FLOW PROCESS',
    'breadcrumbs_title' => 'LOT FLOW PROCESS'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
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

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<div class="panel panel-primary">
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                'highcharts-more',
                'modules/xrange',
                //'modules/exporting',
                //'themes/grid-light',
                'themes/dark-unica',
                //'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'xrange',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    //'height' => 650,
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => $part_name,
                ],
                'subtitle' => [
                    'text' => 'LOT NUMBER : ' . $lot_number
                ],
                'xAxis' => [
                    'type' => 'datetime',
                ],
                'yAxis' => [
                    'title' => [
                        'text' => '',
                    ],
                    'categories' => $categories,
                    'reversed' => true
                ],
                'series' => $data,
            ],
        ]);
        ?>
    </div>
</div>
