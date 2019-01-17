<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'FA Line Efficiency & Loss time <span class="japanesse text-green">(総組ライン能率&ロースタイム）</span>',
    'tab_title' => 'FA Line Efficiency & Loss time',
    'breadcrumbs_title' => 'FA Line Efficiency & Loss time'
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
print_r($data_losstime);
echo '</pre>';*/

?>

<div class="row">
    <div class="col-md-4">
        <div class="form">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
            ]); ?>
            <?= $form->field($model, 'proddate')->widget(\yii\jui\DatePicker::class, [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'class' => 'form-control',
                    'onchange'=>'this.form.submit()'
                ]
            ])->label('Prod. Date') ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

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
                                'type' => 'column',
                                'style' => [
                                    'fontFamily' => 'Source Sans Pro'
                                ],
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
                                'categories' => $eff_categories,
                            ],
                            'tooltip' => [
                                'valueSuffix' => '%'
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Percentage (%)'
                                ],
                                //'max' => 100,
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
                                'column' => [
                                    'dataLabels' => [
                                        'enabled' => true
                                    ],
                                ],
                            ],
                            'series' => $eff_data_series,
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
                                'type' => 'column',
                                'style' => [
                                    'fontFamily' => 'Source Sans Pro'
                                ],
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
                                'categories' => $losstime_line_categories,
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Minutes'
                                ],
                                //'max' => 100,
                            ],
                            'tooltip' => [
                                'valueSuffix' => ' minutes'
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
                                'column' => [
                                    'dataLabels' => [
                                        'enabled' => true
                                    ],
                                    'maxPointWidth' => 100,
                                ],
                            ],
                            'series' => $losstime_line_data_series,
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
                                'text' => null
                            ],
                            'legend' => [
                                'enabled' => false,
                            ],
                            'xAxis' => [
                                'categories' => $losstime_category_categories,
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Minutes'
                                ],
                                //'max' => 100,
                            ],
                            'tooltip' => [
                                'valueSuffix' => ' minutes'
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
                                'column' => [
                                    'dataLabels' => [
                                        'enabled' => true
                                    ],
                                    'maxPointWidth' => 100,
                                ],
                            ],
                            'series' => $losstime_category_data_series,
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