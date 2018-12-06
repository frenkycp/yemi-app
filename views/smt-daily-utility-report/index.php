<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'SMT Utility Report <span class="japanesse text-green"></span>',
    'tab_title' => 'SMT Utility Report',
    'breadcrumbs_title' => 'SMT Utility Report'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

date_default_timezone_set('Asia/Jakarta');

/*echo '<pre>';
print_r($data2);
echo '</pre>';*/
?>
<h4 class="box-title">Last Update : <?= date('Y-m-d H:i:s') ?></h4>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">SMT Utility</a></li>
        <li><a href="#tab_2" data-toggle="tab">SMT Loss time by Line <span class="japanesse"></span></a></li>
        <li><a href="#tab_3" data-toggle="tab">SMT Loss time by Category <span class="japanesse"></span></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                    //'themes/sand-signika',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'line',
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => null,
                    ],  
                    'xAxis' => [
                        'type' => 'datetime',
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Percentage (%)'
                        ],
                        'min' => 0,
                        //'max' => 100,
                    ],
                    'tooltip' => [
                        'shared' => true,
                        'crosshairs' => true,
                        'xDateFormat' => '%Y-%m-%d',
                        'valueSuffix' => '%',
                    ],
                    'plotOptions' => [
                        'line' => [
                            'dataLabels' => [
                                'enabled' => true
                            ],
                        ],
                        'series' => [
                            'cursor' => 'pointer',
                            'dataLabels' => [
                                'allowOverlap' => true
                            ],
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
                        ]
                    ],
                    'series' => $data,
                ],
            ]); ?>
        </div>
        <div class="tab-pane" id="tab_2">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/grid-light',
                    'themes/sand-signika',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => null,
                    ],  
                    'xAxis' => [
                        'type' => 'datetime',
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Minute'
                        ],
                        'min' => 0,
                        'stackLabels' => [
                            'enabled' => true
                        ],
                        //'max' => 100,
                    ],
                    'tooltip' => [
                        //'shared' => true,
                        //'crosshairs' => true,
                        'xDateFormat' => '%Y-%m-%d',
                        'valueSuffix' => 'min',
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true
                            ],
                        ],
                        'series' => [
                            //'cursor' => 'pointer',
                            'dataLabels' => [
                                //'allowOverlap' => true
                                'enabled' => true
                            ],
                            /*'point' => [
                                'events' => [
                                    'click' => new JsExpression("
                                        function(e){
                                            e.preventDefault();
                                            $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                        }
                                    "),
                                ]
                            ]*/
                        ]
                    ],
                    'series' => $data2,
                ],
            ]); ?>
        </div>
        <div class="tab-pane" id="tab_3"></div>
    </div>
</div>

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>