<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    'page_title' => 'Weekly Shipping Chart <span class="japanesse">(週次出荷コンテナー別)</span> - ETD YEMI based <span class="japanesse">(工場出荷日の基準)</span>',
    'tab_title' => 'Shipping Chart',
    'breadcrumbs_title' => 'Shipping Chart'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
//$color = 'DarkSlateBlue';
$color = 'rgba(72,61,139,0.6)';

//$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}");

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
foreach ($tmp_week_arr as $week_no) {
    # code...
}
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
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['serno-output/report']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Year'); ?>
        <?= Html::dropDownList('year', $year, \Yii::$app->params['year_arr'], [
            'class' => 'form-control',
            //'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
    <div class="col-md-2">
        <?= Html::label('Month'); ?>
        <?= Html::dropDownList('month', $month, [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ], [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
</div>
<br/>

<?php ActiveForm::end(); ?>
<u><h5>Last Updated : <?= date('d-m-Y H:i:s') ?></h5></u>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php
        if (count($tmp_week_arr) == 0) {
            
        } else {
            foreach ($tmp_week_arr as $week_no1) {
                if($week_no1->week_ship == $todays_week)
                {
                    echo '<li class="active"><a href="#tab_1_' . $week_no1->week_ship . '" data-toggle="tab">Week ' . $week_no1->week_ship . '</a></li>';
                }
                else
                {
                    echo '<li><a href="#tab_1_' . $week_no1->week_ship . '" data-toggle="tab">Week ' . $week_no1->week_ship . '</a></li>';
                }
            }
            /*if ((int)date('n') == 12 && date('j') > 20) {
                echo '<li><a href="#tab_1_0" data-toggle="tab">Week 2</a></li>';
            }*/
        }
        
        ?>
    </ul>
    <div class="tab-content">
        <?php
        if (count($tmp_week_arr) == 0) {
            echo '<h4>No data found...</h4>';
        } else {
            $sernoFg = app\models\SernoOutput::find()
            ->select(['etd, SUM(qty) as qty, SUM(output) as output'])
            ->where([
                '>=', 'EXTRACT(YEAR_MONTH FROM etd)', $period,
            ])
            ->andWhere(['<>', 'stc', 'ADVANCE'])
            ->groupBy('etd')
            ->all();
            foreach ($tmp_week_arr as $week_no2) {
                if($week_no2->week_ship == $todays_week)
                {
                    echo '<div class="tab-pane active" id="tab_1_' . $week_no2->week_ship .'">';
                }
                else
                {
                    echo '<div class="tab-pane" id="tab_1_' . $week_no2->week_ship .'">';
                }
                
                $data_close = [];
                $data_open = [];
                $data_ng = [];
                $data_delay = [];
                $categories = [];
                $delay_num_arr = [];

                foreach ($sernoFg as $value) {
                    $tmp_week_no = $week_data_arr[$value->etd];

                    if ($tmp_week_no == $week_no2->week_ship) {
                        $remark = count($delay_data_arr) . '<br/>';
                        $remark .= '<table>';
                        $remark .= '</table>';

                        //$total_delay = 500;
                        $total_close = $value->output - (0 + $total_delay);
                        $total_open = $value->qty - $value->output;
                        $presentase_open = ceil(($total_open/$value->qty)*100);
                        $presentase_close = 100 - $presentase_open;
                        //$presentase_open = (int)(100 - $presentase_close);
                        //$data_close[] = (int)$presentase;
                        $data_close[] = [
                            'y' => (int)($presentase_close),
                            'url' => Url::to(['index', 'index_type' => 2, 'etd' => $value->etd]),
                            'qty' => $total_close,
                        ];
                        //$data_open[] = (int)(100 - $presentase_close);
                        $data_open[] = [
                            'y' => $presentase_open > 0 ? $presentase_open : null,
                            'url' => Url::to(['index', 'index_type' => 1, 'etd' => $value->etd]),
                            'qty' => $value->qty - $value->output,
                        ];
                        //$categories[] = $value->etd;
                        $categories[] = date('Y-m-d', strtotime($value->etd));
                    }

                    
                }
                echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/sand-signika',
                    'themes/grid-light',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 400,
                        'width' => null,
                        /**/'style' => [
                            'fontFamily' => 'Source Sans Pro'
                        ],
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
                        'categories' => $categories,
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
                        'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + this.point.qty + " pcs"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'percent',
                            'dataLabels' => [
                                'enabled' => true,
                                //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                'style' => [
                                    'fontSize' => '13px',
                                    'fontWeight' => '0'
                                ],
                            ],
                            //'borderWidth' => 1,
                            //'borderColor' => $color,
                        ],
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
                                'format' => '{point.percentage:.0f}%',
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