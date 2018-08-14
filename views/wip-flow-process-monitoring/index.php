<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Kanban Process-Flow Monitor <span class="japanesse text-green">（かんばん工程流れモニター）</span>',
    'tab_title' => 'Kanban Process-Flow Monitor',
    'breadcrumbs_title' => 'Kanban Process-Flow Monitor'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 60000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

/* echo '<pre>';
print_r($categories);
echo '</pre>'; */

?>

<?php
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
	    'credits' => [
	    	'enabled' => false
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
?>