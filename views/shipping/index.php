<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Shipping Report');
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

?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <?php
                $dailyStyle = '';
                $weeklyStyle = '';
                $monthlyStyle = '';
                
                if(isset($_GET['category']))
                {
                    if($_GET['category'] == 1)
                    {
                        echo 'Weekly Report';
                        $weeklyStyle = 'display: none;';
                        $isWeekly = true;
                    } else {
                        echo 'Monthly Report';
                        $monthlyStyle = 'display: none;';
                        $isWeekly = false;
                    }
                } else {
                    echo 'Daily Report';
                    $dailyStyle = 'display: none;';
                    $isWeekly = false;
                }
                ?> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation" style="<?= $dailyStyle ?>"><?= Html::a('Daily Report', ['index']) ?></li>
                <li role="presentation" style="<?= $weeklyStyle ?>"><?= Html::a('Weekly Report', ['index', 'category' => 1]) ?></li>
                <li role="presentation" style="<?= $monthlyStyle ?>"><?= Html::a('Monthly Report', ['index', 'category' => 2]) ?></li>
            </ul>
        </li>
    </ul>
    
    <?php
    $startDate = new DateTime(date('Y-03-02'));
    $endDate = new DateTime(date('Y-03-t'));
    $startWeek = $startDate->format('W');
    $endWeek = $endDate->format('W');
    ?>
    
    <div class="tab-content" style="">
        <div class="tab-pane active" id="tab_1">
            <div class="nav-tabs-custom" style="<?= $isWeekly ? '' : 'display:none;' ?>">
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
                        
                        $sernoFg = app\models\SernoFgSumViewWeek::find()->where(['week_no' => $j])->orderBy('shipto ASC')->all();
                        $dataClose = [];
                        $dataOpen = [];
                        $dataName = [];
                        $data = [];
                        
                        foreach ($sernoFg as $value) {
                            $presentase = round(($value->actual/$value->plan)*100);
                            $dataClose[] = (int)$presentase;
                            $dataOpen[] = (int)(100 - $presentase);
                            $dataName[] = $value->shipto;
                            $data[] = [
                                'y' => (int)$presentase,
                                'name' => $value->shipto
                            ];
                        }
                        echo Highcharts::widget([
                        'scripts' => [
                            'modules/exporting',
                            'themes/sand-signika',
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'column',
                                'height' => 350,
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
                        echo '</div>';
                    }
                    ?>
                    <!-- <div class="tab-pane active" id="tab_1_1">
                        Week 1
                    </div>
                    <div class="tab-pane" id="tab_1_2">
                        Week 2
                    </div>
                    <div class="tab-pane" id="tab_1_3">
                        Week 3
                    </div>
                    <div class="tab-pane" id="tab_1_4">
                        Week 4
                    </div>
                    <div class="tab-pane" id="tab_1_5">
                        Week 5
                    </div> -->
                </div>
            </div>
        <?php
        if($isWeekly == false)
        {
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
        }
        else
        {
            
        }
        
        ?>
        </div>
    </div>
    <!-- /.tab-content -->
</div>