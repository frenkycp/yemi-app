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
    'page_title' => 'CORRECTIVE PROGRESS <span class="text-green japanesse">(修理中設備の進捗)',
    'tab_title' => 'CORRECTIVE PROGRESS',
    'breadcrumbs_title' => 'CORRECTIVE PROGRESS'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

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
			        //'themes/sand-signika',
			        'themes/grid-light',
			    ],
			    'options' => [
			    	'chart' => [
			    		'type' => 'columnrange',
			    		'inverted' => true,
			    		'height' => 720,
			    		'style' => [
                            'fontFamily' => 'Source Sans Pro'
                        ],
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
				            	'color' => 'black',
				            	//'xHigh' => -40,
				            	//'xLow' => 40,
				            	'inside' => true,
				                'enabled' => true,
				                'useHTML' => true,
				                //'format' => '{y}',
				                'style' => [
			                        'fontSize' => '10px',
			                        'fontWeight' => '10'
			                    ],
			                    'formatter' => new JsExpression('
			                    	function(){
			                    		if (new Date().setHours(0, 0, 0, 0) !== new Date(this.y).setHours(0, 0, 0, 0)) {
				                    		if (this.y === this.point.low){
				                    			return this.point.catatan;
				                    		}
			                    		} else {
			                    			return \'\';
			                    		}
			                    	}
		                    	'),
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
			<span><i class="fa fa-square" style="color: rgba(255, 0, 0, 0.8);"></i> Stop</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span><i class="fa fa-square" style="color: rgba(255, 153, 0, 0.8);"></i> Running</span>
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