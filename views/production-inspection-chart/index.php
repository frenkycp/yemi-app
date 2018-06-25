<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    'page_title' => 'Production Inspection Chart</span>',
    'tab_title' => 'Production Inspection Chart',
    'breadcrumbs_title' => 'Production Inspection Chart'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
//$color = 'DarkSlateBlue';
$color = 'rgba(72,61,139,0.6)';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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
/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

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

            /*$sernoFg = app\models\SernoOutput::find()
            ->select(['etd, SUM(qty) as qty, SUM(output) as output, SUM(ng) as ng, WEEK(ship,4) as week_no'])
            ->where([
                'WEEK(ship,4)' => $j,
                'LEFT(id,4)' => date('Y'),
            ])
            ->andWhere(['<>', 'stc', 'ADVANCE'])
            //->andWhere(['<>', 'stc', 'NOSO'])
            ->groupBy('etd')
            ->all();*/

            /*$sernoFg = app\models\ProductionInspection::find()
            ->select([
                'proddate' => 'proddate',
                'qa_ok' => 'qa_ok',
                'total' => 'COUNT(qa_ok)'
            ])
            ->where([
                'week_no' => $j,
                'LEFT(proddate,4)' => date('Y'),
            ])
            ->groupBy('proddate, qa_ok')
            ->all();*/

            $sernoFg = $data[$j];

            $tmp_period = [];

            foreach ($sernoFg as $value) {
                if (!in_array($value['proddate'], $tmp_period)) {
                    $tmp_period[] = $value['proddate'];
                }
            }

            $data_close = [];
            $data_open = [];

            foreach ($tmp_period as $value) {
                $tmp_total_open = 0;
                $tmp_total_close = 0;
                foreach ($sernoFg as $value2) {
                    if ($value2['proddate'] == $value) {
                        if ($value2['qa_ok'] == 'OK') {
                            $tmp_total_close += $value2['total'];
                        } else {
                            $tmp_total_open += $value2['total'];
                        }
                    }
                }
                $total_qty = $tmp_total_open + $tmp_total_close;
                $presentase_close = 0;
                $presentase_open = 0;
                if ($total_qty > 0) {
                    $presentase_close = round(($tmp_total_close / $total_qty) * 100);
                    $presentase_open = 100 - $presentase_close;
                }
                
                $data_close[] = [
                    'y' => (int)($presentase_close),
                    'url' => Url::to(['/production-inspection/index', 'prod_date' => $value, 'status' => 'OK']),
                    'qty' => $tmp_total_close,
                ];
                $data_open[] = [
                    'y' => $presentase_open,
                    'url' => Url::to(['/production-inspection/index', 'prod_date' => $value, 'status' => 'NG']),
                    'qty' => $tmp_total_open,
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
                    'categories' => $tmp_period,
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
                    'enabled' => true,
                    'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + this.point.qty + " rows"; }'),
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
                        'borderWidth' => 1,
                        'borderColor' => $color,
                    ],
                    'series' => [
                        
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Outstanding',
                        'data' => $data_open,
                        'color' => 'FloralWhite',
                        'dataLabels' => [
                            'enabled' => true,
                            'color' => 'black',
                            'format' => '{point.percentage:.0f}% ({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                            'allowOverlap' => true,
                        ],
                        'showInLegend' => false,
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ]
                    ],
                    [
                        'name' => 'Completed',
                        'data' => $data_close,
                        'color' => $color,
                        'dataLabels' => [
                            'enabled' => true,
                            'color' => 'black',
                            'format' => '{point.percentage:.0f}% ({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                        ],
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                            ]
                        ]
                    ],
                ]
            ],
        ]);
            echo '</div>';
        }
        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            //'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>
</div>