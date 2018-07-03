<?php

use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\models\search\MenuSearch $searchModel
*/

$this->title = [
    'page_title' => 'Weekly JIT Parts  <span class="text-green">（週次JIT部品納入)</span> - ETD Supplier based',
    'tab_title' => 'Weekly JIT Parts',
    'breadcrumbs_title' => 'Weekly JIT Parts'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    h1 span { 
        font-family: 'MS PGothic', Osaka, Arial, sans-serif; 
    }
    table {
        font-size: 12px;
    }
");

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
        foreach ($data as $key => $value) {
            if($key == $this_week)
            {
                echo '<li class="active"><a href="#tab_1_' . $key . '" data-toggle="tab">Week ' . $key . '</a></li>';
            }
            else
            {
                echo '<li><a href="#tab_1_' . $key . '" data-toggle="tab">Week ' . $key . '</a></li>';
            }
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php
        foreach ($data as $key => $value) {
            if($key == $this_week)
            {
                echo '<div class="tab-pane active" id="tab_1_' . $key .'">';
            }
            else
            {
                echo '<div class="tab-pane" id="tab_1_' . $key .'">';
            }

            echo Highcharts::widget([
                'scripts' => [
                    'modules/exporting',
                    'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'column',
                    ],
                    'credits' => [
                        'enabled' =>false
                    ],
                    'title' => [
                        'text' => ''
                    ],
                    'subtitle' => [
                        'text' => ''
                    ],
                    'xAxis' => [
                        'type' => 'category',
                        'categories' => $value[0]['category'],
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'title' => [
                            'text' => 'Total Completion'
                        ],
                        //'gridLineWidth' => 0,
                    ],
                    'tooltip' => [
                        'enabled' => false,
                        //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + this.point.qty + " pcs"; }'),
                    ],
                    'plotOptions' => [
                        'column' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '{point.percentage:.2f}%',
                                'color' => 'black',
                                //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                                'style' => [
                                    //'fontSize' => '14px',
                                    'textOutline' => '0px',
                                    'fontWeight' => '0'
                                ],
                            ],
                            //'borderWidth' => 1,
                            //'borderColor' => $color,
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
                    'series' => $value[0]['data']
                ],
            ]);

            echo '</div>';
        }

        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
    </div>
</div>