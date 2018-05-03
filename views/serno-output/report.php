<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Production Summary Report');
$this->params['breadcrumbs'][] = $this->title;
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
$color = 'DodgerBlue';

$this->registerCss(".tab-content > .tab-pane,
.pill-content > .pill-pane {
    display: block;     
    height: 0;          
    overflow-y: hidden; 
}

.tab-content > .active,
.pill-content > .active {
    height: auto;       
} ");

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

$startDate = new DateTime(date('Y-m-01'));
$endDate = new DateTime(date('Y-m-t'));
$startWeek = $startDate->format('W')-1;
$endWeek = $endDate->format('W')-1;
?>
    
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php
        for($i = $startWeek; $i <= $endWeek; $i++)
        {
            if($i == $startWeek)
            {
                echo '<li class="active"><a href="#tab_1_' . $i . '" data-toggle="tab">Week ' . $i . '</a></li>';
            }
            else
            {
                echo '<li><a href="#tab_1_' . $i . '" data-toggle="tab">Week ' . $i . '</a></li>';
            }
        }
        ?>
        <!-- <li class="active"><a href="#tab_1_1" data-toggle="tab">Week 1</a></li>
        <li><a href="#tab_1_2" data-toggle="tab">Week 2</a></li>
        <li><a href="#tab_1_3" data-toggle="tab">Week 3</a></li>
        <li><a href="#tab_1_4" data-toggle="tab">Week 4</a></li>
        <li><a href="#tab_1_5" data-toggle="tab">Week 5</a></li> -->
    </ul>
    <div class="tab-content">
        <?php
        for($j = $startWeek; $j <= $endWeek; $j++)
        {
            if($j == $startWeek)
            {
                echo '<div class="tab-pane active" id="tab_1_' . $j .'">';
            }
            else
            {
                echo '<div class="tab-pane" id="tab_1_' . $j .'">';
            }

            
            //$sernoFg = app\models\SernoFgSumViewWeek::find()->where(['week_no' => $j])->orderBy('shipto ASC')->all();
            $sernoFg = app\models\SernoOutputView::find()->where(['week_no' => $j])->orderBy('etd ASC')->all();
            $dataClose = [];
            $dataOpen = [];
            $dataName = [];

            foreach ($sernoFg as $value) {
                $presentase = round(($value->output/$value->qty)*100);
                //$dataClose[] = (int)$presentase;
                $dataClose[] = [
                    'y' => (int)$presentase,
                    'url' => Url::to(['index', 'index_type' => 2, 'etd' => $value->etd]),
                    //'url' => 'http://localhost/yemi-app/web/serno-output/index?index_type=1'
                ];
                //$dataOpen[] = (int)(100 - $presentase);
                $dataOpen[] = [
                    'y' => (int)(100 - $presentase),
                    'url' => Url::to(['index', 'index_type' => 1, 'etd' => $value->etd]),
                ];
                //$dataName[] = $value->etd;
                $dataName[] = date('d-M-Y', strtotime($value->etd));
            }
            echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 500,
                    'width' => null
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => 'Weekly Report'
                ],
                'subtitle' => [
                    'text' => 'Week ' . $j
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
                    //'enabled' => false
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
                                //'click' => new JsExpression('function(){ location.href = this.options.url; }')
                                'click' => new JsExpression('function(){ window.open(this.options.url); }')
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
            echo '</div>';
        }
        ?>
    </div>
</div>