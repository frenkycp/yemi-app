<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'CURRENT SALES PROGRESS <span class="japanesse text-green">(今月の売上進捗状況)</span>',
    'tab_title' => 'CURRENT SALES PROGRESS',
    'breadcrumbs_title' => 'CURRENT SALES PROGRESS'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

/*echo '<pre>';
print_r($tmp_data_amount_budget);
echo '</pre>';*/

?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Business Unit  (BU別)</a></li>
        <li class=""><a href="#tab_2" data-toggle="tab">Accumulation (合計)</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/grid-light',
                    //'themes/sand-signika',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => null,
                    'xAxis' => [
                        'categories' => $categories,
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'AMOUNT (USD)'
                        ],
                    ],
                    'plotOptions' => [
                        'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('
                                        function(){
                                            $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                        }
                                    '),
                                ]
                            ]
                        ]
                    ],
                    'series' => $data
                ],
            ]);
            ?>
        </div>
        <div class="tab-pane" id="tab_2">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/grid-light',
                    //'themes/sand-signika',
                    //'themes/dark-unica',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                        'height' => 450,
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => null
                    ],
                    'subtitle' => [
                        'text' => null
                    ],
                    'xAxis' => [
                        'categories' => [$period]
                    ],
                    'yAxis' => [
                        'allowDecimals' => false,
                        'min' => 0,
                        'title' => [
                            'text' => 'AMOUNT (USD)'
                        ]
                    ],
                    'legend' => [
                        'enabled' => false,
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal'
                        ],
                        'series' => [
                            'cursor' => 'pointer',
                            'point' => [
                                'events' => [
                                    'click' => new JsExpression('
                                        function(){
                                            $("#modal").modal("show").find(".modal-body").html(this.options.remark);
                                        }
                                    '),
                                ]
                            ]
                        ]
                    ],
                    'series' => $data2
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>