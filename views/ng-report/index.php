<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'Weekly Corrective <span class="text-green">(週次修繕)',
    'tab_title' => 'Weekly Corrective',
    'breadcrumbs_title' => 'Weekly Corrective'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');
$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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

$startDate = date('Y-06-01');
$endDate = date('Y-m-t');
$startWeek = app\models\SernoCalendar::find()->where(['ship' => $startDate])->one()->week_ship;
$endWeek = app\models\SernoCalendar::find()->where(['ship' => $endDate])->one()->week_ship;
$date_today = date('Y-m-d');
$weekToday = app\models\SernoCalendar::find()->where(['etd' => $date_today])->one()->week_ship;
$startWeek = 42;
$endWeek = 52;
?>

<u><h5>Last Updated : <?= date('d-M-Y H:i:s') ?></h5></u>
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
            $ngProgress = app\models\MesinCheckNg::find()->select(['CONVERT(date, [db_owner].[MESIN_CHECK_NG].[mesin_last_update]) as tgl, DATEPART(wk, [db_owner].[MESIN_CHECK_NG].[mesin_last_update]) as week_no, SUM(CASE WHEN repair_status=\'O\' THEN 1 ELSE 0 END) as total_open, SUM(CASE WHEN repair_status=\'C\' THEN 1 ELSE 0 END) as total_close'])
            ->where(['DATEPART(wk, [db_owner].[MESIN_CHECK_NG].[mesin_last_update])' => $j])
            ->groupBy('CONVERT(date, [db_owner].[MESIN_CHECK_NG].[mesin_last_update]), DATEPART(wk, [db_owner].[MESIN_CHECK_NG].[mesin_last_update])')->all();
            $dataClose = [];
            $dataOpen = [];
            $dataOther = [];
            $dataName = [];

            foreach ($ngProgress as $value) {
                $total_open = $value->total_open;
                $total_close = $value->total_close;
                $total_data = $total_open + $total_close;
                $presentase = floor(($total_close/$total_data)*100);
                //$dataClose[] = (int)$presentase;
                $dataClose[] = [
                    'y' => (int)($presentase),
                    'url' => Url::to(['mesin-check-ng/index',
                        'repair_status' => 'C',
                        'mesin_last_update' => $value->tgl]),
                    'qty' => $total_close,
                ];
                //$dataOpen[] = (int)(100 - $presentase);
                $dataOpen[] = [
                    'y' => (int)(100 - $presentase),
                    'url' => Url::to(['mesin-check-ng/index',
                        'repair_status' => 'O',
                        'mesin_last_update' => $value->tgl]),
                    'qty' => $total_open,
                ];
                //$dataName[] = $value->etd;
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
                    'text' => null
                ],
                'subtitle' => [
                    'text' => null
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