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

$this->title = 'Corrective Progress';
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



<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Last Update : <?= date('d M Y H:i:s') ?></h3>
	</div>
	<div class="panel-body">
		<?php
		if (count($data_date) == 0) {
			echo 'All progress completed...';
		} else {
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
			    		'height' => 420,
			    	],
			    	'title' => [
				        'text' => $title
				    ],
				    'credits' => [
				    	'enabled' => false
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
				        'min' => 0,
				        'max' => 31,
				        'tickInterval' => 1
				    ],

				    'tooltip' => [
				    	'enabled' => false,
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
		}
		
		?>
		<hr>
		<div class="text-center">
			<span><i class="fa fa-circle" style="color: rgba(255, 0, 0, 0.8);"></i> Stop</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span><i class="fa fa-circle" style="color: rgba(255, 153, 0, 0.8);"></i> Running</span>
		</div>
		
	</div>
</div>

<?php

yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    //'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();

?>