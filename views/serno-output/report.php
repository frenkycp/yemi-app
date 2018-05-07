<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Production Summary Report');
$this->params['breadcrumbs'][] = $this->title;
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
$color = 'DarkSlateBlue';

date_default_timezone_set('Asia/Jakarta');

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



function getSundayWeekNumber($date)
{
    //$date = new DateTime(strtotime($date));
    $weekNumber = (int)$date->format('W');

    if ($date->format('w') === '0') { // Sunday
        $weekNumber += 1;
        if (53 === $weekNumber) { // If the week is now 53, subtract 52
            $weekNumber -= 52;
        }
    }

    return $weekNumber;
}

$startDate = new DateTime(date('Y-m-01'));
$endDate = new DateTime(date('Y-m-t'));
$startWeek = getSundayWeekNumber($startDate);
$endWeek = getSundayWeekNumber($endDate);
//$startWeek = $startDate->format('W');
//$endWeek = $endDate->format('W');
$weekToday = getSundayWeekNumber(new DateTime(date('Y-m-d')));
?>
<h5>Last Updated : <?= date('d-m-Y H:i:s') ?></h5>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php
        for($i = $startWeek; $i <= $endWeek; $i++)
        {
            if($i == $weekToday)
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
            if($j == $weekToday)
            {
                echo '<div class="tab-pane active" id="tab_1_' . $j .'">';
            }
            else
            {
                echo '<div class="tab-pane" id="tab_1_' . $j .'">';
            }

            
            //$sernoFg = app\models\SernoFgSumViewWeek::find()->where(['week_no' => $j])->orderBy('shipto ASC')->all();
            //$sernoFg = app\models\SernoOutputView::find()->where(['week_no' => $j])->orderBy('etd ASC')->all();
            $sernoFg = app\models\SernoOutput::find()->select(['dst, gmc, etd, ship, SUM(qty) as qty, SUM(output) as output, SUM(ng) as ng, WEEK(ship,4) as week_no'])
                    ->where(['WEEK(ship,4)' => $j])
                    ->groupBy('etd')
                    ->all();
            $dataClose = [];
            $dataOpen = [];
            $dataOther = [];
            $dataName = [];

            foreach ($sernoFg as $value) {
                $totalClose = $value->output - $value->ng;
                $presentaseNg = round(($value->ng/$value->qty)*100);
                $presentase = floor(($totalClose/$value->qty)*100);
                //$dataClose[] = (int)$presentase;
                $dataClose[] = [
                    'y' => (int)($presentase),
                    'url' => Url::to(['index', 'index_type' => 2, 'etd' => $value->etd]),
                    'qty' => $totalClose,
                ];
                $dataOther[] = [
                    'y' => (int)$presentaseNg,
                    'url' => Url::to(['index', 'index_type' => 3, 'etd' => $value->etd]),
                    'qty' => $value->ng,
                ];
                //$dataOpen[] = (int)(100 - $presentase);
                $dataOpen[] = [
                    'y' => (int)(100 - ($presentase + $presentaseNg)),
                    'url' => Url::to(['index', 'index_type' => 1, 'etd' => $value->etd]),
                    'qty' => $value->qty - $value->output,
                ];
                //$dataName[] = $value->etd;
                $dataName[] = date('Y-m-d', strtotime($value->etd));
            }
            echo Highcharts::widget([
            'scripts' => [
                'modules/exporting',
                'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 400,
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
                    'categories' => $dataName,
                    'labels' => [
                        'formatter' => new JsExpression('function(){ return \'<a href="container-progress?etd=\' + this.value + \'">\' + this.value + \'</a>\'; }'),
                    ],
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => 'Total Completion'
                    ],
                    'gridLineWidth' => 0,
                ],
                'tooltip' => [
                    //'enabled' => false
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                            'style' => [
                                'fontSize' => '14px',
                                'fontWeight' => '0'
                            ],
                        ],
                        'borderWidth' => 2,
                        'borderColor' => $color,
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
                'series' => [
                    [
                        'name' => 'Outstanding',
                        'data' => $dataOpen,
                        'color' => 'FloralWhite',
                        'dataLabels' => [
                            'enabled' => true,
                            'color' => 'black',
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                        ],
                        'showInLegend' => false
                    ],
                    [
                        'name' => 'NG',
                        'data' => $dataOther,
                        'color' => 'pink',
                        'dataLabels' => [
                            'enabled' => false,
                            /* 'color' => 'black',
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ], */
                            
                        ],
                    ],
                    [
                        'name' => 'Completed',
                        'data' => $dataClose,
                        'color' => $color,
                        'dataLabels' => [
                            'enabled' => true,
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                        ]
                    ]
                ]
            ],
        ]);
            echo '</div>';
        }
        ?>
    </div>
</div>