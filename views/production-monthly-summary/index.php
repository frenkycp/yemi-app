<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

$this->title = [
    'page_title' => 'Monthly Summary <span class="japanesse text-green"></span>',
    'tab_title' => 'Monthly Summary',
    'breadcrumbs_title' => 'Monthly Summary'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

?>

<?php
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
            'enabled' => false,
            'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + this.point.qty + " pcs"; }'),
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
                //'borderColor' => $color,
            ],
        ],
        'series' => $series
    ],
]);
?>