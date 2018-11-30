<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'SMT Utility Report <span class="japanesse text-green"></span>',
    'tab_title' => 'SMT Utility Report',
    'breadcrumbs_title' => 'SMT Utility Report'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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

date_default_timezone_set('Asia/Jakarta');

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Last Update : <?= date('Y-m-d H:i:s') ?></h3></div>
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
                //'themes/sand-signika',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'line',
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => null,
                ],  
                'xAxis' => [
                    'type' => 'datetime',
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Percentage (%)'
                    ],
                    'min' => 0,
                    //'max' => 100,
                ],
                'tooltip' => [
                    'shared' => true,
                    'crosshairs' => true,
                    'xDateFormat' => '%Y-%m-%d',
                    'valueSuffix' => '%',
                ],
                'plotOptions' => [
                    'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                            ]
                        ]
                    ],
                    'line' => [
                        'dataLabels' => [
                            'enabled' => true
                        ],
                    ],
                ],
                'series' => $data,
            ],
        ]); ?>
    </div>
</div>