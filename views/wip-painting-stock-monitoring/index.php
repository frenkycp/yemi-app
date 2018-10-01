<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Stock WIP Monitor <span class="japanesse text-green">（仕掛在庫モニター）</span> - Started + Completed qty <span class="japanesse text-green">(加工中 +完成台数)</span>',
    'tab_title' => 'Stock WIP Monitor',
    'breadcrumbs_title' => 'Stock WIP Monitor'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

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
*/
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
<h5 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h5>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_1" data-toggle="tab">LINE-X</a></li>
		<li><a href="#tab_2" data-toggle="tab">ALL</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_1">
			<div class="row" style="display: flex; justify-content: center;">
				<div class="col-sm-3">
					<div class="box box-success box-solid">
						<div class="box-header with-border text-center">
							CABINET ASSY
						</div>
						<div class="box-body">
							<?php
							echo Highcharts::widget([
								'scripts' => [
					                //'modules/exporting',
					                'highcharts-more',
					                //'modules/solid-gauge',
					                //'themes/sand-signika',
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
								        'height' => 250,
					                ],
					                'title' => [
								        'text' => null,
								        'style' => [
								        	'fontSize' => '12px'
								        ],
								        'margin' => 0
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
								        'max' => $data_cab_assy['limit_qty'],

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
								            'rotation' => 'auto',
								            'style' => [
								            	'fontSize' => '10px'
								            ]
								        ],
								        'title' => [
								            //'text' => 'pcs'
								        ],
								        'plotBands' => [
								        	[
									            'from' => $data_cab_assy['plot_green']['from'],
									            'to' => $data_cab_assy['plot_green']['to'],
									            'color' => '#55BF3B' // green
									        ], [
									            'from' => $data_cab_assy['plot_yellow']['from'],
									            'to' => $data_cab_assy['plot_yellow']['to'],
									            'color' => '#DDDF0D' // yellow
									        ], [
									            'from' => $data_cab_assy['plot_red']['from'],
									            'to' => $data_cab_assy['plot_red']['to'],
									            'color' => '#DF5353' // red
									        ]
									    ]
								    ],
								    'plotOptions' => [
							            'gauge' => [
							                'wrap' => false
							            ]
							        ],
								    'series' => [
								    	[
									        'name' => 'Stock',
									        'data' => [
									        	$data_cab_assy['onhand_qty']
									        ],
									        'tooltip' => [
									            'valueSuffix' => ' pcs'
									        ]
									    ]
									]
					            ],
							]);
							?>
						</div>
					</div>
				</div>
				<div class="col-sm-1" style="display: flex; flex-direction: column; justify-content: center;">
					<img style="margin-right: auto; margin-left: auto; display: block; width: 100%;" src="<?= Yii::getAlias('@web') ?>/arrowr.png">
				</div>
				<div class="col-sm-3">
					<div class="box box-success box-solid">
						<div class="box-header with-border text-center">
							PAINTING
						</div>
						<div class="box-body">
							<?php
							echo Highcharts::widget([
								'scripts' => [
					                //'modules/exporting',
					                'highcharts-more',
					                //'modules/solid-gauge',
					                //'themes/sand-signika',
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
								        'height' => 250,
					                ],
					                'title' => [
								        'text' => null,
								        'style' => [
								        	'fontSize' => '12px'
								        ],
								        'margin' => 0
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
								        'max' => $data_painting['limit_qty'],

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
								            'rotation' => 'auto',
								            'style' => [
								            	'fontSize' => '10px'
								            ]
								        ],
								        'title' => [
								            //'text' => 'pcs'
								        ],
								        'plotBands' => [
								        	[
									            'from' => $data_painting['plot_green']['from'],
									            'to' => $data_painting['plot_green']['to'],
									            'color' => '#55BF3B' // green
									        ], [
									            'from' => $data_painting['plot_yellow']['from'],
									            'to' => $data_painting['plot_yellow']['to'],
									            'color' => '#DDDF0D' // yellow
									        ], [
									            'from' => $data_painting['plot_red']['from'],
									            'to' => $data_painting['plot_red']['to'],
									            'color' => '#DF5353' // red
									        ]
									    ]
								    ],
								    'plotOptions' => [
							            'gauge' => [
							                'wrap' => false
							            ]
							        ],
								    'series' => [
								    	[
									        'name' => 'Stock',
									        'data' => [
									        	$data_painting['onhand_qty']
									        ],
									        'tooltip' => [
									            'valueSuffix' => ' pcs'
									        ]
									    ]
									]
					            ],
							]);
							?>
						</div>
					</div>
				</div>
				<div class="col-sm-1" style="display: flex; flex-direction: column; justify-content: center;">
					<img style="margin-right: auto; margin-left: auto; display: block; width: 100%;" src="<?= Yii::getAlias('@web') ?>/arrowr.png">
				</div>
				<div class="col-sm-3">
					<div class="box box-success box-solid">
						<div class="box-header with-border text-center">
							FINAL ASSY
						</div>
						<div class="box-body">
							<?php
							echo Highcharts::widget([
								'scripts' => [
					                //'modules/exporting',
					                'highcharts-more',
					                //'modules/solid-gauge',
					                //'themes/sand-signika',
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
								        'height' => 250,
					                ],
					                'title' => [
								        'text' => null,
								        'style' => [
								        	'fontSize' => '12px'
								        ],
								        'margin' => 0
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
								        'max' => $data_final_assy['limit_qty'],

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
								            'rotation' => 'auto',
								            'style' => [
								            	'fontSize' => '10px'
								            ]
								        ],
								        'title' => [
								            //'text' => 'pcs'
								        ],
								        'plotBands' => [
								        	[
									            'from' => $data_final_assy['plot_green']['from'],
									            'to' => $data_final_assy['plot_green']['to'],
									            'color' => '#55BF3B' // green
									        ], [
									            'from' => $data_final_assy['plot_yellow']['from'],
									            'to' => $data_final_assy['plot_yellow']['to'],
									            'color' => '#DDDF0D' // yellow
									        ], [
									            'from' => $data_final_assy['plot_red']['from'],
									            'to' => $data_final_assy['plot_red']['to'],
									            'color' => '#DF5353' // red
									        ]
									    ]
								    ],
								    'plotOptions' => [
							            'gauge' => [
							                'wrap' => false
							            ]
							        ],
								    'series' => [
								    	[
									        'name' => 'Stock',
									        'data' => [
									        	$data_final_assy['onhand_qty']
									        ],
									        'tooltip' => [
									            'valueSuffix' => ' pcs'
									        ]
									    ]
									]
					            ],
							]);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tab_2">
			<div class="box box-primary">
				<div class="box-header with-border">
					<?php
					foreach ($data as $key => $value) {
						echo '<div class="col-sm-2" style="margin-top: 10px;">';
						echo '<div class="box box-primary box-solid">
						<div class="box-header with-border text-center">
							' . $key . '
						</div>
						<div class="box-body">';
						echo Highcharts::widget([
							'scripts' => [
				                //'modules/exporting',
				                'highcharts-more',
				                //'modules/solid-gauge',
				                //'themes/sand-signika',
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
							        'height' => 170,
				                ],
				                'title' => [
							        'text' => null,
							        'style' => [
							        	'fontSize' => '12px'
							        ],
							        'margin' => 0
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
							            'rotation' => 'auto',
							            'style' => [
							            	'fontSize' => '10px'
							            ]
							        ],
							        'title' => [
							            //'text' => 'pcs'
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
							    'plotOptions' => [
						            'gauge' => [
						                'wrap' => false
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
						echo '</div>';
						echo '</div>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
