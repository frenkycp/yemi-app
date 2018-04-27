<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Production Summary');
$this->params['breadcrumbs'][] = $this->title;
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
$color = 'DodgerBlue';

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

?>
<div class="box box-primary">
    <div class="box-header with-border">
        <!-- <h3 class="box-title">Prod. Summary</h3> -->
    </div>
    <div class="box-body">
        <div class="chart">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 350
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
                        'type' => 'category'
                    ],
                    'xAxis' => [
                        'categories' => $dataName
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'title' => [
                            'text' => 'Total Completion'
                        ],
                        'gridLineWidth' => 0
                    ],
                    'tooltip' => [
                        'enabled' => false
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.percentage:.0f}%',
                                'style' => [
                                    'fontSize' => '14px',
                                ],
                            ],
                            'borderWidth' => 2,
                            'borderColor' => $color,
                        ],
                        'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    //'click' => new JsExpression('function(){ location.href = "www.facebook.com"; }')
                                ]
                            ]
                        ]
                    ],
                    'series' => [
                        [
                            'name' => 'Outstanding',
                            'data' => $dataOpen,
                            'color' => 'FloralWhite',
                            'dataLabels' => [
                                'enabled' => false
                            ],
                            'showInLegend' => false
                        ],
                        [
                            'name' => 'Completed',
                            'data' => $dataClose,
                            'color' => $color,
                        ]
                    ]
                ],
            ]);

            ?>
        </div>
    </div>
</div>
