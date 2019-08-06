<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'FA Line Efficiency & Loss time Monthly <span class="japanesse text-green">(月次総組ライン能率&ロースタイム）</span>',
    'tab_title' => 'FA Line Efficiency & Loss time Monthly',
    'breadcrumbs_title' => 'FA Line Efficiency & Loss time Monthly'
];
$color = 'ForestGreen';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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
print_r($data2);
echo '</pre>';*/

?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['dpr-line-efficiency-monthly/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Line'); ?>
        <?= Html::dropDownList('line', \Yii::$app->request->get('line'), $line_dropdown, [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
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

<!--<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Last Update : <?= date('Y-m-d H:i:s') ?></h3>
    </div>
    <div class="box-body"> -->
        <h4 class="box-title">Last Update : <?= date('Y-m-d H:i:s') ?></h4>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Line Efficiency</a></li>
                <li><a href="#tab_2" data-toggle="tab">FA Loss time by Line <span class="japanesse">（ライン別総組ロースタイム）</span></a></li>
                <li><a href="#tab_3" data-toggle="tab">FA Loss time by Category <span class="japanesse">（原因カテゴリー別総組ロースタイム）</span></a></li>
                <li><a href="#tab_4" data-toggle="tab">Availability <span class="japanesse"></span></a></li>
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
                                'style' => [
                                    'fontFamily' => 'Source Sans Pro'
                                ],
                            ],
                            'credits' => [
                                'enabled' => false
                            ],
                            'title' => [
                                'text' => 'Line : ' . $line
                            ],
                            'subtitle' => [
                                'text' => 'Target Efficiency : ' . $target_eff . '%'
                            ],
                            'legend' => [
                                'enabled' => false,
                            ],
                            'xAxis' => [
                                //'categories' => $categories,
                                'type' => 'datetime',
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Percentage (%)'
                                ],
                                'min' => 0,
                                'max' => $max,
                                'plotLines' => [
                                    [
                                        'value' => $target_eff,
                                        'color' =>  '#00FF00',
                                        'width' => 2,
                                        'zIndex' => 0,
                                        'label' => ['text' => '']
                                    ]
                                ],
                                //'max' => 100,
                            ],
                            'tooltip' => [
                                //'shared' => true,
                                //'crosshairs' => true,
                                'xDateFormat' => '%Y-%m-%d',
                                'valueSuffix' => '%',
                            ],
                            'plotOptions' => [
                                /*'series' => [
                                    'cursor' => 'pointer',
                                    'point' => [
                                        'events' => [
                                            'click' => new JsExpression('
                                                function(){
                                                    $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                                }
                                            '),
                                        ]
                                    ]
                                ],*/
                                'series' => [
                                    'cursor' => 'pointer',
                                    'point' => [
                                        'events' => [
                                            'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                            //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                                        ]
                                    ]
                                ],
                                'line' => [
                                    'dataLabels' => [
                                        'enabled' => true
                                    ],
                                ],
                            ],
                            'series' => $data1,
                        ],
                    ]); ?>
                </div>
                <div class="tab-pane" id="tab_2">
                    <?php
                    echo Highcharts::widget([
                        'scripts' => [
                            //'modules/exporting',
                            //'themes/grid-light',
                            //'themes/sand-signika',
                            //'themes/dark-unica',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'line',
                                'style' => [
                                    'fontFamily' => 'Source Sans Pro'
                                ],
                            ],
                            'credits' => [
                                'enabled' => false
                            ],
                            'title' => [
                                'text' => 'Line : ' . $line
                            ],
                            'legend' => [
                                'enabled' => false,
                            ],
                            'xAxis' => [
                                //'categories' => $categories,
                                'type' => 'datetime',
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Minutes'
                                ],
                                'plotLines' => [
                                    [
                                        'value' => 100,
                                        'color' =>  '#D3D3D3',
                                        'width' => 1,
                                        'zIndex' => 0,
                                        'label' => ['text' => '']
                                    ]
                                ],
                                'stackLabels' => [
                                    'enabled' => true,
                                    'allowOverlap' => true
                                ],
                                //'max' => 100,
                            ],
                            'tooltip' => [
                                //'shared' => true,
                                //'crosshairs' => true,
                                'xDateFormat' => '%Y-%m-%d',
                                'valueSuffix' => ' minutes',
                            ],
                            'plotOptions' => [
                                /**/'series' => [
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
                                'line' => [
                                    'dataLabels' => [
                                        'enabled' => true
                                    ],
                                ],
                            ],
                            'series' => $data2,
                        ],
                    ]); ?>
                </div>
                <div class="tab-pane" id="tab_3">
                    <?php
                    echo Highcharts::widget([
                        'scripts' => [
                            //'modules/exporting',
                            //'themes/grid-light',
                            //'themes/sand-signika',
                            //'themes/dark-unica',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'column',
                                'style' => [
                                    'fontFamily' => 'Source Sans Pro'
                                ],
                            ],
                            'credits' => [
                                'enabled' => false
                            ],
                            'title' => [
                                'text' => 'Line : ' . $line
                            ],
                            'legend' => [
                                'enabled' => false,
                            ],
                            'xAxis' => [
                                'categories' => $categories_losstime_category,
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Minutes'
                                ],
                            ],
                            'tooltip' => [
                                //'shared' => true,
                                //'crosshairs' => true,
                                'xDateFormat' => '%Y-%m-%d',
                                'valueSuffix' => ' minutes',
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
                                'column' => [
                                    'dataLabels' => [
                                        'enabled' => true
                                    ],
                                    'maxPointWidth' => 100,
                                ],
                            ],
                            'series' => $data3,
                        ],
                    ]); ?>
                </div>
                <div class="tab-pane" id="tab_4">
                    <?php
                    echo Highcharts::widget([
                        'scripts' => [
                            //'modules/exporting',
                            //'themes/grid-light',
                            //'themes/sand-signika',
                            //'themes/dark-unica',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'column',
                                'style' => [
                                    'fontFamily' => 'Source Sans Pro'
                                ],
                            ],
                            'credits' => [
                                'enabled' => false
                            ],
                            'title' => [
                                'text' => 'Line : ' . $line
                            ],
                            'xAxis' => [
                                //'categories' => $categories,
                                'type' => 'datetime',
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Minutes'
                                ],
                                /*'plotLines' => [
                                    [
                                        'value' => 100,
                                        'color' =>  '#D3D3D3',
                                        'width' => 1,
                                        'zIndex' => 0,
                                        'label' => ['text' => '']
                                    ]
                                ],*/
                                //'max' => 100,
                            ],
                            'tooltip' => [
                                //'shared' => true,
                                //'crosshairs' => true,
                                'xDateFormat' => '%Y-%m-%d',
                                'valueSuffix' => ' minutes',
                            ],
                            'plotOptions' => [
                                /*'series' => [
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
                                ],*/
                                'column' => [
                                    'stacking' => 'normal',
                                    'dataLabels' => [
                                        'enabled' => true,
                                        'allowOverlap' => true
                                    ],
                                ],
                            ],
                            'series' => $working_time_losstime,
                        ],
                    ]); ?>
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
    <!--</div>
</div>-->