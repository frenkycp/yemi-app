<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Operation Ratio | GO-SHOP',
    'tab_title' => 'Operation Ratio',
    'breadcrumbs_title' => 'Operation Ratio'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
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
    'action' => Url::to(['go-shop-operation-ratio/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Year'); ?>
        <?= Html::dropDownList('year', $year, \Yii::$app->params['year_arr'], [
            'class' => 'form-control',
            //'onchange'=>'this.form.submit()'
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

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">ALL DRIVERS</h3>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                    //'themes/sand-signika',
                    //'themes/dark-unica'
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'width' => null,
                        'style' => [
                            'fontFamily' => 'sans-serif'
                        ],
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'title' => [
                        'text' => null
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        //'offset' => 10,
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'HOURS'
                        ],
                        //'max' => $max_order,
                        'minTickInterval' => 1,
                        'stackLabels' => [
                            'enabled' => true,
                            'style' => [
                                'color' => 'red'
                            ],
                        ],
                    ],
                    'tooltip' => [
                        //'shared' => true,
                        'crosshairs' => true,
                        'xDateFormat' => '%Y-%m-%d',
                        'valueSuffix' => ' hours',
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.percentage:.0f}% ({point.y})',
                                //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                'style' => [
                                    //'fontSize' => '14px',
                                    'fontWeight' => '0'
                                ],
                            ],
                            'borderWidth' => 1,
                            //'borderColor' => $color,
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
                            ],*/
                            'maxPointWidth' => 80,
                        ]
                    ],
                    'series' => $data2
                ],
            ]); ?>
        </div>
    </div>
</div>

<div class="box box-solid box-info">
    <div class="box-header with-border">
        <!-- <h3 class="box-title">Last Update : <?= ''; //date('Y-m-d H:i:s'); ?></h3> -->
        <h3 class="box-title">EACH DRIVER</h3>
    </div>
    <div class="box-body">
        <div class="box-group" id="accordion">
        <?php
        foreach ($data as $key => $value) {
            
            //$panel_class = ' box-primary';
            ?>
            <div class="panel box box-solid box-primary">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $key; ?>">
                            <?= $key . ' - ' . $value['nama']; ?>
                        </a>
                    </h4>
                </div>
                <div id="collapse<?= $key; ?>" class="panel-collapse collapse">
                    <div class="box-body">
                        <?php
                        echo Highcharts::widget([
                            'scripts' => [
                                //'modules/exporting',
                                //'themes/grid-light',
                                //'themes/sand-signika',
                            ],
                            'options' => [
                                'chart' => [
                                    'type' => 'column',
                                    'style' => [
                                        'fontFamily' => 'sans-serif'
                                    ],
                                ],
                                'credits' => [
                                    'enabled' =>false
                                ],
                                'title' => [
                                    'text' => null
                                ],
                                'xAxis' => [
                                    'type' => 'datetime',
                                    'offset' => 10,
                                ],
                                'yAxis' => [
                                    'title' => [
                                        'text' => null
                                    ],
                                    //'max' => $max_order,
                                    'minTickInterval' => 1,
                                    'stackLabels' => [
                                        'enabled' => true,
                                        'style' => [
                                            'color' => 'red'
                                        ],
                                        'format' => '{total:.1f}',
                                    ],
                                ],
                                'tooltip' => [
                                    //'shared' => true,
                                    'crosshairs' => true,
                                    'xDateFormat' => '%Y-%m-%d',
                                    'valueSuffix' => ' hours'
                                ],
                                'plotOptions' => [
                                    'column' => [
                                        'stacking' => 'percent',
                                        'dataLabels' => [
                                            'enabled' => true,
                                            'format' => '{point.percentage:.0f}% ({point.y})',
                                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                            'style' => [
                                                //'fontSize' => '14px',
                                                'fontWeight' => '0'
                                            ],
                                        ],
                                        'borderWidth' => 1,
                                        //'borderColor' => $color,
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
                                        ],*/
                                        'maxPointWidth' => 80,
                                    ]
                                ],
                                'series' => $value['data']
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
            <?php
        }

        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();

        ?>
        </div>
    </div>
</div>