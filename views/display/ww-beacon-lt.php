<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Wood Working Lot LT <span class="japanesse text-green"></span>',
    'tab_title' => 'Wood Working Lot LT',
    'breadcrumbs_title' => 'Wood Working Lot LT'
];
$color = 'ForestGreen';

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
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
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    th, td {vertical-align: middle !important;}
");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data_losstime);
echo '</pre>';*/

?>
<span style="color: white; font-size: 2em;">Last Update : <?= date('Y-m-d H:i'); ?></span>
<div class="panel panel-primary">
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/grid-light',
                //'themes/sand-signika',
                'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'bar',
                    'style' => [
                        'fontFamily' => 'Source Sans Pro'
                    ],
                    'height' => '600px',
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => null
                ],
                'legend' => [
                    'enabled' => false,
                ],
                'xAxis' => [
                    'categories' => $categories,
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Days'
                    ],
                    'max' => 10,
                    'allowDecimals' => false,
                    'plotLines' => [
                        [
                            'value' => 5,
                            'color' => 'red',
                            'width' => 4,
                            'zIndex' => 0,
                            'label' => ['text' => 'MAX']
                        ]
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    //'shared' => true,
                    //'crosshairs' => true,
                    //'xDateFormat' => '%Y-%m-%d',
                    'valueSuffix' => ' days',
                ],
                'plotOptions' => [
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]
                    ],
                    'bar' => [
                        'dataLabels' => [
                            'enabled' => true,
                            //'rotation' => -90,
                            'align' => 'left',
                            //'y' => 5,
                        ],
                        'maxPointWidth' => 100,
                    ],
                ],
                'series' => $data,
            ],
        ]); ?>
    </div>
</div>