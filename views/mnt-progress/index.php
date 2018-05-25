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

$this->title = 'Maintenance Progress';
$this->params['breadcrumbs'][] = $this->title;
date_default_timezone_set('Asia/Jakarta');

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

<h4>Last Update : <?= date('d M Y H:i:s') ?></h4>

<?php
$month = date('M');
echo Highcharts::widget([
	'scripts' => [
		'highcharts-more',
        'modules/exporting',
        'themes/sand-signika',
        //'themes/grid-light',
    ],
    'options' => [
    	'chart' => [
    		'type' => 'columnrange',
    		'inverted' => true,
    		'height' => 4000,
    	],
    	'title' => [
	        'text' => $title
	    ],

	    'subtitle' => [
	        'text' => $subtitle
	    ],
	    'xAxis' => [
	        'categories' => $data_categories,
	        'maxPadding' => 0.05
	    ],

	    'yAxis' => [
	        'title' => [
	            'text' => 'Date',
	        ],
	        'min' => 1,
	        'max' => 31,
	        'tickInterval' => 1
	    ],

	    'tooltip' => [
	        'valueSuffix' => $value_suffix
	    ],

	    'plotOptions' => [
	        'columnrange' => [
	            'dataLabels' => [
	                'enabled' => true,
	                'format' => '{y}',
	                'style' => [
                        'fontSize' => '14px',
                        'fontWeight' => '10'
                    ],
	            ]
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
                        //'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                        //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                    ]
                ]
            ]
	    ],

	    'legend' => [
	        'enabled' => false
	    ],

	    'series' => [
	    	[
		        'name' => 'Repair Progress',
		        'data' => $data_date
		    ]
		]
    ],
    
]);

yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    //'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();

?>