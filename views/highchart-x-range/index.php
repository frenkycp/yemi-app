<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

/*echo '<pre>';
print_r($data);
echo '</pre>';*/

echo Highcharts::widget([
	'scripts' => [
		'highcharts-more',
		'modules/exporting',
		'modules/xrange',
        'themes/grid',

	],
	'options' => [
		'chart' => [
            'type' => 'xrange',
        ],
        'title' => [
	        'text' => 'Highcharts X-range'
	    ],
	    'xAxis' => [
	        'type' => 'datetime'
	    ],
	    'yAxis' => [
	        'title' => [
	            'text' => ''
	        ],
	        'categories' => $categories,
	        'reversed' => true
	    ],
	    'series' => $data
	],
]);