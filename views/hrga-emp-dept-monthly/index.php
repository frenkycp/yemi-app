<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Manpower Planning by Department <span>(要員計画・部門別)</span>',
    'tab_title' => 'Manpower Planning by Department',
    'breadcrumbs_title' => 'Manpower Planning by Department'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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

?>
<?php
/*echo '<pre>';
print_r($section);
echo '</pre>';

echo '<pre>';
print_r($category);
echo '</pre>';

echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['hrga-emp-dept-monthly']),
]); ?>

<div class="row">
    <div class="col-md-4">
        <?php echo '<label class="control-label">Select date range</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'from_date',
            'attribute2' => 'to_date',
            'options' => ['placeholder' => 'Start date'],
            'options2' => ['placeholder' => 'End date'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="box box-success">
    <div class="box-header with-border">
        <h4 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h4>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
                // 'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 500,
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => 'PERIOD ' . $model->from_date . ' to ' . $model->to_date
                ],
                'subtitle' => [
                    'text' => null
                ],
                'xAxis' => [
                    'categories' => $category
                ],
                'yAxis' => [
                    'labels' => [
                        'format' => '{value}',
                        'style' => [
                            //'color' => Highcharts.getOptions().colors[1]
                        ]
                    ],
                    'title' => [
                        'text' => 'Total Employee (人数)',
                        'style' => [
                            'font-family' => "'MS PGothic', Osaka, Arial, sans-serif",
                            //'color' => Highcharts.getOptions().colors[1]
                        ]
                    ],
                    //'max' => 2500,
                    
                    'stackLabels' => [
                        'enabled' => true,
                        'allowOverlap' => true,
                        'style' => [
                            'fontWeight' => 'bold',
                            //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        ]
                    ]
                    /*[
                        'labels' => [
                            'format' => '{value}',
                            'style' => [
                                //'color' => Highcharts.getOptions().colors[1]
                            ]
                        ],
                        'title' => [
                            'text' => 'Total Employee (人数)',
                            'style' => [
                                'font-family' => "'MS PGothic', Osaka, Arial, sans-serif",
                                //'color' => Highcharts.getOptions().colors[1]
                            ]
                        ],
                        'max' => 2500,
                        
                        'stackLabels' => [
                            'enabled' => true,
                            'allowOverlap' => true,
                            'style' => [
                                'fontWeight' => 'bold',
                                //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                            ]
                        ]
                    ],
                    [//primary axis
                        'labels' => [
                            'format' => '{value}',
                            'style' => [
                                //'color' => Highcharts.getOptions().colors[1]
                            ]
                        ],
                        'title' => [
                            'text' => 'Total Production Qty exclude KD  (生産台数・KDを含まない)',
                            'style' => [
                                'font-family' => "'MS PGothic', Osaka, Arial, sans-serif",
                                //'color' => Highcharts.getOptions().colors[1]
                            ]
                        ],
                        'min' => 0,
                        'max' => 6000,
                        'opposite' => true,
                    ],*/
                    
                    /*'min' => 0,
                    'title' => [
                        'text' => 'Total fruit consumption'
                    ],
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            'fontWeight' => 'bold',
                            //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        ]
                    ]*/
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => $menu == 2 ? false : true,
                            'style' => [
                                'textOutline' => '0px',
                                'fontSize' => '10px',
                                'fontWeight' => '0'
                            ],
                            //'allowOverlap' => \Yii::$app->request->get('menu') !== null ? false : true,
                            //'color' => 'Black'
                            //color => (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        ]
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ],
                        /*'events' => [
                            'legendItemClick' => new JsExpression('
                                function(event) {
                                    if (!this.visible)
                                        return false;

                                    var seriesIndex = this.index;
                                    var series = this.chart.series;

                                    for (var i = 0; i < series.length; i++)
                                    {
                                        if (series[i].index != seriesIndex)
                                        {
                                            series[i].visible ?
                                            series[i].hide() :
                                            series[i].show();
                                        } 
                                    }
                                    return false;
                                }
                            ')
                        ]*/
                    ]
                ],
                'series' => $data
            ],
        ]);
        ?>
        <hr/>
        <?php
        /*echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => $title
                ],
                'subtitle' => [
                    'text' => $subtitle
                ],
                'xAxis' => [
                    'categories' => $category
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Total fruit consumption'
                    ],
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            'fontWeight' => 'bold',
                            //color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        ]
                    ]
                ],
                'series' => $data
            ],
        ]);*/
        ?>
    </div>
</div>