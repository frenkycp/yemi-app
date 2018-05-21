<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Machine Master Plan');
$this->params['breadcrumbs'][] = $this->title;

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

$startDate = date('Y-m-01');
$endDate = date('Y-m-t');
$startWeek = app\models\SernoCalendar::find()->where(['ship' => $startDate])->one()->week_ship;
$endWeek = app\models\SernoCalendar::find()->where(['ship' => $endDate])->one()->week_ship;
$date_today = date('Y-m-d');
$weekToday = app\models\SernoCalendar::find()->where(['etd' => $date_today])->one()->week_ship;

?>

<u><h5>Last Updated : <?= date('d-M-Y H:i:s') ?></h5></u>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
        <?php
        $color = 'MediumAquamarine';
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
            $ngProgress = app\models\MesinCheckDtr::find()->select(['CONVERT(date, [db_owner].[MESIN_CHECK_DTR].[master_plan_maintenance]) as tgl, DATEPART(wk, master_plan_maintenance) as week_no, SUM(CASE WHEN master_plan_maintenance IS NOT NULL THEN 1 ELSE 0 END) as total_data, SUM(CASE WHEN mesin_last_update IS NOT NULL THEN 1 ELSE 0 END) as total_close'])
            ->where(['DATEPART(wk, [db_owner].[MESIN_CHECK_DTR].[master_plan_maintenance])' => $j])
            ->groupBy('CONVERT(date, [db_owner].[MESIN_CHECK_DTR].[master_plan_maintenance]), DATEPART(wk, [db_owner].[MESIN_CHECK_DTR].[master_plan_maintenance])')->all();
            $dataClose = [];
            $dataOpen = [];
            $dataOther = [];
            $dataName = [];

            foreach ($ngProgress as $value) {
            	$total_data = $value->total_data;
            	$total_close = $value->total_close;
                $total_open = $total_data - $total_close;
                $presentase = floor(($total_close/$total_data)*100);

                $dataOpen[] = [
                    'y' => (int)(100 - $presentase),
                    'url' => Url::to(['mesin-check-dtr/index',
                        'master_plan_maintenance' => $value->tgl,
                        'status' => 0
                    ]),
                    'qty' => $total_open,
                ];

                $dataClose[] = [
                    'y' => (int)($presentase),
                    'url' => Url::to(['mesin-check-dtr/index',
                        'master_plan_maintenance' => $value->tgl,
                        'status' => 1
                    ]),
                    'qty' => $total_close,
                ];
                
                $dataName[] = date('Y-m-d', strtotime($value->tgl));
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
                    'text' => 'Master Plan'
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
                            'color' => 'black',
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
                            //'color' => 'black',
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                        ],
                        'showInLegend' => false
                    ],
                    [
                        'name' => 'Completed',
                        'data' => $dataClose,
                        'color' => $color,
                        'dataLabels' => [
                            'enabled' => true,
                            //'color' => 'black',
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