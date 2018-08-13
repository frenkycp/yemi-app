<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'WIP (Painting) Stock Monitoring <span class="japanesse"></span>',
    'tab_title' => 'WIP (Painting) Stock Monitoring',
    'breadcrumbs_title' => 'WIP (Painting) Stock Monitoring'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

/*$js = <<< SCRIPT
	$(document).ready(function() { 
	    $.ajax({ 
	        url: 'wip-painting-stock-monitoring/ajax-example', 
	        type: 'post',
	        data: {nilai1: 2, nilai2:4},
	        success: function(data) { 
	            console.log(data); 
	        }, 
	    }); 
	});
SCRIPT
; 
$this->registerJs($js, View::POS_END);

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 5000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );*/

$data_painting = $data['PAINTING'];
$data_cab_assy = $data['CAB ASSY'];
$data_final_assy = $data['FINAL ASSY'];

$height = 250;
$title_y = -100;
$stops_arr = [
    [0.75, '#55BF3B'], // green
    [0.85, '#DDDF0D'], // yellow
    [1, '#DF5353'] // red
];

/*echo '<pre>';
print_r($data_painting);
echo '</pre>';*/
?>

<div class="box box-primary" style="display: none;">
	<div class="box-header"></div>
	<div class="box-body">
		<div class="col-sm-4">
			<?php
			echo Highcharts::widget([
				'scripts' => [
	                //'modules/exporting',
	                'highcharts-more',
	                'modules/solid-gauge',
	                //'themes/sand-signika',
	                //'themes/grid-light',
	            ],
	            'options' => [
	            	'chart' => [
	                    'type' => 'solidgauge',
	                    'height' => $height,
	                ],
	                'title' => null,
	                'pane' => [
				        'center' => ['50%', '85%'],
				        'size' => '140%',
				        'startAngle' => -90,
				        'endAngle' => 90,
				        'background' => [
				            'backgroundColor' => '#EEE',
				            'innerRadius' => '60%',
				            'outerRadius' => '100%',
				            'shape' => 'arc'
				        ]
				    ],
				    'tooltip' => [
				        'enabled' => false
				    ],
				    'credits' => [
				    	'enabled' => false
				    ],
				    'yAxis' => [
			        	'stops' => $stops_arr,
				        'lineWidth' => 0,
				        'minorTickInterval' => 0.001,
				        'tickAmount' => 0,
				        'title' => [
				            'y' => $title_y,
				            'text' => 'PAINTING'
				        ],
				        'labels' => [
				            'y' => 16
				        ],
				        'min' => 0,
				        'max' => 300,
				        //'tickInterval' => (300 / 1000)
				    ],
				    'plotOptions' => [
				        'solidgauge' => [
				            'dataLabels' => [
				                'y' => 5,
				                'borderWidth' => 0,
				                'useHTML' => true
				            ]
				        ]
				    ],
				    'series' => [
				    	[
					        'name' => 'Speed',
					        'data' => [100],
					        'dataLabels' => [
					            'format' => '<div style="text-align:center"><span style="font-size:25px;color:black">{y}</span><br/><span style="font-size:12px;color:silver">pcs</span></div>'
					        ],
					        'tooltip' => [
					            'valueSuffix' => ' km/h'
					        ]
					    ]
					]
	            ],
			]);
			?>
		</div>
		<div class="col-sm-4">
			<?php
			echo Highcharts::widget([
				'scripts' => [
	                //'modules/exporting',
	                'highcharts-more',
	                'modules/solid-gauge',
	                //'themes/sand-signika',
	                'themes/grid-light',
	            ],
	            'options' => [
	            	'chart' => [
	                    'type' => 'solidgauge',
	                    'height' => $height,
	                ],
	                'title' => null,
	                'pane' => [
				        'center' => ['50%', '85%'],
				        'size' => '140%',
				        'startAngle' => -90,
				        'endAngle' => 90,
				        'background' => [
				            'backgroundColor' => '#EEE',
				            'innerRadius' => '60%',
				            'outerRadius' => '100%',
				            'shape' => 'arc'
				        ]
				    ],
				    'tooltip' => [
				        'enabled' => false
				    ],
				    'credits' => [
				    	'enabled' => false
				    ],
				    'yAxis' => [
			        	'stops' => $stops_arr,
				        'lineWidth' => 0,
				        'minorTickInterval' => null,
				        'tickAmount' => 2,
				        'title' => [
				            'y' => $title_y,
				            'text' => 'CABINET ASSY'
				        ],
				        'labels' => [
				            'y' => 16
				        ],
				        'min' => 0,
				        'max' => 200,
				    ],
				    'plotOptions' => [
				        'solidgauge' => [
				            'dataLabels' => [
				                'y' => 5,
				                'borderWidth' => 0,
				                'useHTML' => true
				            ]
				        ]
				    ],
				    'series' => [
				    	[
					        'name' => 'Speed',
					        'data' => [180],
					        'dataLabels' => [
					            'format' => '<div style="text-align:center"><span style="font-size:25px;color:black">{y}</span><br/><span style="font-size:12px;color:silver">pcs</span></div>'
					        ],
					        'tooltip' => [
					            'valueSuffix' => ' km/h'
					        ]
					    ]
					]
	            ],
			]);
			?>
		</div>
		<div class="col-sm-4">
			<?php
			echo Highcharts::widget([
				'scripts' => [
	                //'modules/exporting',
	                'highcharts-more',
	                'modules/solid-gauge',
	                //'themes/sand-signika',
	                //'themes/grid-light',
	            ],
	            'options' => [
	            	'chart' => [
	                    'type' => 'solidgauge',
	                    'height' => $height,
	                ],
	                'title' => null,
	                'pane' => [
				        'center' => ['50%', '85%'],
				        'size' => '140%',
				        'startAngle' => -90,
				        'endAngle' => 90,
				        'background' => [
				            'backgroundColor' => '#EEE',
				            'innerRadius' => '60%',
				            'outerRadius' => '100%',
				            'shape' => 'arc'
				        ]
				    ],
				    'tooltip' => [
				        'enabled' => false
				    ],
				    'credits' => [
				    	'enabled' => false
				    ],
				    'yAxis' => [
			        	'stops' => $stops_arr,
				        'lineWidth' => 0,
				        'minorTickInterval' => null,
				        'tickAmount' => 2,
				        'title' => [
				            'y' => $title_y,
				            'text' => 'FINAL ASSY'
				        ],
				        'labels' => [
				            'y' => 16
				        ],
				        'min' => 0,
				        'max' => 200,
				    ],
				    'plotOptions' => [
				        'solidgauge' => [
				            'dataLabels' => [
				                'y' => 5,
				                'borderWidth' => 0,
				                'useHTML' => true
				            ]
				        ]
				    ],
				    'series' => [
				    	[
					        'name' => 'Speed',
					        'data' => [210],
					        'dataLabels' => [
					            'format' => '<div style="text-align:center"><span style="font-size:25px;color:black">{y}</span><br/><span style="font-size:12px;color:silver">pcs</span></div>'
					        ],
					        'tooltip' => [
					            'valueSuffix' => ' km/h'
					        ]
					    ]
					]
	            ],
			]);
			?>
		</div>
		
	</div>
</div>
<div class="box box-primary">
	<div class="box-header"></div>
	<div class="box-body">
		<?php
		foreach ($data as $key => $value) {
			echo '<div class="col-sm-4">';
			echo Highcharts::widget([
				'scripts' => [
	                //'modules/exporting',
	                'highcharts-more',
	                //'modules/solid-gauge',
	                'themes/sand-signika',
	                //'themes/grid-light',
	                //'themes/default',
	            ],
	            'options' => [
	            	'chart' => [
	                    'type' => 'gauge',
	                    'plotBackgroundColor' => null,
				        'plotBackgroundImage' => null,
				        'plotBorderWidth' => 0,
				        'plotShadow' => false,
				        'height' => 400,
	                ],
	                'title' => [
				        'text' => $key
				    ],
				    'credits' => [
				    	'enabled' => false
				    ],
				    'pane' => [
				        'startAngle' => -150,
				        'endAngle' => 150,
				        'background' => [
				        	[
					            'backgroundColor' => [
					                'linearGradient' => [ 'x1' => 0, 'y1' => 0, 'x2' => 0, 'y2' => 1 ],
					                'stops' => [
					                    [0, '#FFF'],
					                    [1, '#333']
					                ]
					            ],
					            'borderWidth' => 0,
					            'outerRadius' => '109%'
					        ], [
					            'backgroundColor' => [
					                'linearGradient' => [ 'x1' => 0, 'y1' => 0, 'x2' => 0, 'y2' => 1 ],
					                'stops' => [
					                    [0, '#333'],
					                    [1, '#FFF']
					                ]
					            ],
					            'borderWidth' => 1,
					            'outerRadius' => '107%'
					        ], [
				            // default background
					        ], [
					            'backgroundColor' => '#DDD',
					            'borderWidth' => 0,
					            'outerRadius' => '105%',
					            'innerRadius' => '103%'
					        ]
					    ]
				    ],
				    'yAxis' => [
				        'min' => 0,
				        'max' => $value['limit_qty'],

				        'minorTickInterval' => 'auto',
				        'minorTickWidth' => 1,
				        'minorTickLength' => 10,
				        'minorTickPosition' => 'inside',
				        'minorTickColor' => '#666',

				        'tickPixelInterval' => 30,
				        'tickWidth' => 2,
				        'tickPosition' => 'inside',
				        'tickLength' => 10,
				        'tickColor' => '#666',
				        'labels' => [
				            'step' => 2,
				            'rotation' => 'auto'
				        ],
				        'title' => [
				            'text' => 'pcs'
				        ],
				        'plotBands' => [
				        	[
					            'from' => $value['plot_green']['from'],
					            'to' => $value['plot_green']['to'],
					            'color' => '#55BF3B' // green
					        ], [
					            'from' => $value['plot_yellow']['from'],
					            'to' => $value['plot_yellow']['to'],
					            'color' => '#DDDF0D' // yellow
					        ], [
					            'from' => $value['plot_red']['from'],
					            'to' => $value['plot_red']['to'],
					            'color' => '#DF5353' // red
					        ]
					    ]
				    ],
				    'series' => [
				    	[
					        'name' => 'Stock',
					        'data' => [
					        	$value['onhand_qty']
					        ],
					        'tooltip' => [
					            'valueSuffix' => ' pcs'
					        ]
					    ]
					]
	            ],
			]);
			echo '</div>';
		}
		?>
	</div>
</div>