<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

//$this->title = 'Shipping Chart <span class="text-green">週次出荷（コンテナー別）</span>';
$this->title = [
    'page_title' => 'Weekly Shipping Chart <span class="text-green">(週次出荷コンテナー別)</span> - ETD YEMI based <span class="text-green">(工場出荷日の基準)</span>',
    'tab_title' => 'Shipping Chart',
    'breadcrumbs_title' => 'Shipping Chart'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
//$color = 'DarkSlateBlue';
$color = 'rgba(72,61,139,0.6)';

$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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
?>
<u><h5>Last Updated : <?= date('d-m-Y H:i:s') ?></h5></u>
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
        if ((int)date('n') == 12 && date('j') > 20) {
            echo '<li><a href="#tab_1_0" data-toggle="tab">Week 2</a></li>';
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

            $sernoFg = app\models\SernoOutput::find()
            ->select(['etd, SUM(qty) as qty, SUM(output) as output, WEEK(ship,4) as week_no'])
            ->where([
                'WEEK(ship,4)' => $j,
                'LEFT(id,4)' => date('Y'),
            ])
            ->andWhere(['<>', 'stc', 'ADVANCE'])
            //->andWhere(['<>', 'stc', 'NOSO'])
            ->groupBy('etd')
            ->all();
            $data_close = [];
            $data_open = [];
            $data_ng = [];
            $data_delay = [];
            $categories = [];
            $delay_num_arr = [];

            foreach ($sernoFg as $value) {
                $vms_date = $value->vms;
                /*$delay_data_arr = app\models\SernoInput::find()
                ->joinWith('sernoOutput')
                ->where([
                    //'WEEK(ship,4)' => $j,
                    //'LEFT(id,4)' => date('Y'),
                    'tb_serno_output.etd' => $value->etd
                ])
                ->andWhere(['<>', 'stc', 'ADVANCE'])
                //->andWhere(['<>', 'stc', 'NOSO'])
                ->andWhere('tb_serno_input.proddate>tb_serno_output.etd')
                ->all();*/

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
        if ((int)date('n') == 12 && date('j') > 20) {
            echo '<div class="tab-pane" id="tab_1_0">';
            $sernoFg = app\models\SernoOutput::find()
            ->select(['etd, SUM(qty) as qty, SUM(output) as output, WEEK(ship,4) as week_no'])
            ->where([
                'WEEK(ship,4)' => 2,
                'LEFT(id,4)' => date('Y') + 1,
            ])
            ->andWhere(['<>', 'stc', 'ADVANCE'])
            //->andWhere(['<>', 'stc', 'NOSO'])
            ->groupBy('etd')
            ->all();
            $data_close = [];
            $data_open = [];
            $data_ng = [];
            $data_delay = [];
            $categories = [];
            $delay_num_arr = [];

            foreach ($sernoFg as $value) {
                $vms_date = $value->vms;
                /*$delay_data_arr = app\models\SernoInput::find()
                ->joinWith('sernoOutput')
                ->where([
                    //'WEEK(ship,4)' => $j,
                    //'LEFT(id,4)' => date('Y'),
                    'tb_serno_output.etd' => $value->etd
                ])
                ->andWhere(['<>', 'stc', 'ADVANCE'])
                //->andWhere(['<>', 'stc', 'NOSO'])
                ->andWhere('tb_serno_input.proddate>tb_serno_output.etd')
                ->all();*/

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
                                    'fontSize' => '14px',
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
        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            //'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>
</div>