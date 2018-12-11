<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'SMT Utility & Loss Time Management <span class="japanesse text-green">( SMT稼働率・ロスタイム管理）</span>',
    'tab_title' => 'SMT Utility & Loss Time Management',
    'breadcrumbs_title' => 'SMT Utility & Loss Time Management'
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
print_r($losstime_category);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['smt-daily-utility-report/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Year'); ?>
        <?= Html::dropDownList('year', $year, \Yii::$app->params['year_arr'], [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
    <div class="col-md-2">
        <?= Html::label('Month'); ?>
        <?= Html::dropDownList('month', $month, [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ], [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
</div>
<br/>

<?php ActiveForm::end(); ?>

<h4 class="box-title">Last Update : <?= date('Y-m-d H:i:s') ?></h4>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Working Ratio <span class="japanesse">（稼働率）</a></li>
        <li><a href="#tab_2" data-toggle="tab">Operation Ratio <span class="japanesse">（操業率）</span></a></li>
        <li><a href="#tab_3" data-toggle="tab">Loss time by Line <span class="japanesse">（ライン別ロスタイム)</span></a></li>
        <li><a href="#tab_4" data-toggle="tab">Loss time by Category <span class="japanesse">(カテゴリー別ロスタイム)</span></a></li>
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
                        //'shared' => true,
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
                    'series' => $data['working_ratio'],
                ],
            ]); ?>
        </div>
        <div class="tab-pane" id="tab_2">
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
                        //'shared' => true,
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
                    'series' => $data['operation_ratio'],
                ],
            ]); ?>
        </div>
        <div class="tab-pane" id="tab_3">
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
                            'cursor' => 'pointer',
                            'dataLabels' => [
                                //'allowOverlap' => true
                                'enabled' => true
                            ],
                            /**/'point' => [
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
                    'series' => $data2,
                ],
            ]); ?>
        </div>
        <div class="tab-pane" id="tab_4">
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
                    'text' => null
                ],
                'subtitle' => [
                    'text' => null
                ],
                'legend' => [
                    'enabled' => false
                ],
                'xAxis' => [
                    'type' => 'category',
                    //'categories' => $categories
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Total in Minute'
                    ],
                ],
                'tooltip' => [
                    'headerFormat' => '<span style="font-size:11px">{series.name}</span><br>',
                    'pointFormat' => '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} min</b><br/>'
                ],
                'plotOptions' => [
                    /**/'column' => [
                        'dataLabels' => [
                            'enabled' => true,
                            //'format' => '{point.y} pcs ({point.total_kubikasi} m3)'
                        ]
                    ],
                    'series' => [
                        /*'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-body').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]*/
                    ]
                ],
                'series' => $data_losstime_category,
            ],
        ]);
        ?>
        </div>
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