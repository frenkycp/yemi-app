<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'IPQA Dashboard <span class="japanesse text-green"></span>',
    'tab_title' => 'IPQA Dashboard',
    'breadcrumbs_title' => 'IPQA Dashboard'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse {
        font-family: 'MS PGothic', Osaka, Arial, sans-serif;
    }
");

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
print_r($data['outstanding']['data']);
echo '</pre>';*/
?>

<div class="box box-primary">
    <div class="box-header ui-sortable-handle">
        <div class="box-title"> </div>
        <div class="pull-right box-tools">
            <?= Html::a('VIEW ALL DATA', Url::to('@web/ipqa-patrol-tbl/index'), ['class' => 'btn btn-success btn-sm', 'target' => '_blank']); ?>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    'themes/grid-light',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => 'OUTSTANDING PROBLEMS (SECTION)',
                    ],
                    'xAxis' => [
                        'categories' => $data['outstanding']['categories'],
                        'title' => [
                            //'text' => 'SECTION'
                        ]
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'TOTAL QTY',
                            //'rotation' => 0,
                            //'align' => 'high'
                        ],
                        'stackLabels' => [
                            'enabled' => true,
                        ],
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        //'valueSuffix' => ' seconds'
                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => false,
                            ],
                        ],
                        'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                                ]
                            ]
                        ]
                    ],
                    'series' => $data['outstanding']['data'],
                ],
            ]);

            ?>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/sand-signika',
                    //'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'zoomType' => 'x'
                        //'height' => 350
                    ],
                    'title' => [
                        'text' => 'Outstanding With Due Date'
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        //'categories' => $value['category'],
                    ],
                    'yAxis' => [
                        //'min' => 0,
                        'title' => [
                            'text' => 'Qty'
                        ],
                        //'gridLineWidth' => 0,
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'xDateFormat' => '%A, %b %e %Y',
                        //'valueSuffix' => ' min'
                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            //'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                            ],
                        ],
                        'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                                ]
                            ]
                        ]
                    ],
                    'series' => $data['ok']['data'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>