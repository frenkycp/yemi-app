<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Shipping Report (Week View)');
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
$chartHeight = 200;

$dataOpen = [100, 80, 60, 40, 20, 0, 30, 60, 90];
foreach ($dataOpen as $value) {
    $dataClose[] = 100 - $value;
}
$dataName = [
    'Destinasi 1', 
    'Destinasi 2', 
    'Destinasi 3', 
    'Destinasi 4', 
    'Destinasi 5', 
    'Destinasi 6', 
    'Destinasi 7', 
    'Destinasi 8', 
    'Destinasi 9'
];

$title = 'Title';
$subtitle = 'Subtitle';

?>

<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Week 1</h3>
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
                                    'height' => $chartHeight
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
                                    'type' => 'category',
                                    'categories' => $dataName
                                ],
                                'yAxis' => [
                                    'min' => 0,
                                    'max' => 100,
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
                                                'fontSize' => '10px',
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
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Week 2</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="areaChart" style="height:<?= $chartHeight ?>px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Week 3</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="areaChart" style="height:<?= $chartHeight ?>px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Week 4</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="areaChart" style="height:<?= $chartHeight ?>px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Week 5</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="areaChart" style="height:<?= $chartHeight ?>px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Week 6</h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <canvas id="areaChart" style="height:<?= $chartHeight ?>px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>