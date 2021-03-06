<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

$this->title = [
    'page_title' => 'Internal Setup Ratio <span class="japanesse light-green">内段取り比率管理</span>',
    'tab_title' => 'Internal Setup Ratio',
    'breadcrumbs_title' => 'Internal Setup Ratio'
];

$this->registerCss("
	.japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	.content-wrapper {background-color: #000;}
	.content-header {color: white;}
	.form-control, .control-label {background-color: #000; color: rgb(255, 235, 59); border-color: white;}
	.box-title {font-weight: bold;}
	.box-header .box-title, .control-label{font-size: 1.5em;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em}
	body {background-color: #000;}
	//.box-header {background-color: " . \Yii::$app->params['purple_color'] . " !important; color: white !important;}
");

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

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['smt-dandori/index']),
]); ?>

<div class="row">
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Location</h3>
			</div>
			<div class="box-body">
				<?= Html::dropDownList('location', $location, [
			    	'WM03' => 'SMT',
			    	'WI02' => 'INJ LARGE',
			    	'WI01' => 'INJ SMALL',
			    	'WM02' => 'PCB AUTO INS.',
			    ], [
			        'class' => 'form-control',
			        'onchange'=>'this.form.submit()',
			        'style' => 'height: 40px; padding: 3px 12px; font-size:1.5em;'
			    ]); ?>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">LINE</h3>
			</div>
			<div class="box-body">
				<?= Html::dropDownList('line', $line, [
			    	'01' => '01',
			    	'02' => '02',
			    ], [
			        'class' => 'form-control',
			        'onchange'=>'this.form.submit()',
			        'style' => 'height: 40px; padding: 3px 12px; font-size:1.5em;'
			    ]); ?>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">YEAR</h3>
			</div>
			<div class="box-body">
				<?= Html::dropDownList('year', $year, \Yii::$app->params['year_arr'], [
		            'class' => 'form-control',
		            'onchange'=>'this.form.submit()',
		            'style' => 'height: 40px; padding: 3px 12px; font-size:1.5em;'
		        ]); ?>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
				<div class="box-header with-border">
					<h3 class="box-title">MONTH</h3>
				</div>
				<div class="box-body">
					<?= Html::dropDownList('month', $month, [
			            '01' => 'Jan',
			            '02' => 'Feb',
			            '03' => 'Mar',
			            '04' => 'Apr',
			            '05' => 'May',
			            '06' => 'Jun',
			            '07' => 'Jul',
			            '08' => 'Aug',
			            '09' => 'Sep',
			            '10' => 'Oct',
			            '11' => 'Nov',
			            '12' => 'Dec',
			        ], [
			            'class' => 'form-control',
			            'onchange'=>'this.form.submit()',
			            'style' => 'height: 40px; padding: 3px 12px; font-size:1.5em;'
			        ]); ?>
				</div>
			</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="box box-default box-solid">
			<!--<div class="box-header with-border">
				<h3 class="box-title">Dandori Utilization</h3>
			</div>-->
			<div class="box-body">
				<div class="col-md-12">
					<?php
					echo Highcharts::widget([
						'scripts' => [
		                    //'modules/exporting',
		                    //'themes/grid-light',
		                    'themes/dark-unica',
		                ],
		                'options' => [
		                    'chart' => [
		                        'type' => 'line',
		                        'style' => [
		                            'fontFamily' => 'sans-serif',
		                        ],
		                        'height' => 290
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
		                        [
		                        	'title' => [
			                            'text' => 'Dandori (%)'
			                        ],
			                        'gridLineDashStyle' => 'Dash',
			                        'min' => 0,
			                        //'max' => 100,
			                        'plotLines' => [
		                                [
		                                    'value' => 10,
		                                    'color' => 'yellow',
		                                    'width' => 2,
		                                    'zIndex' => 0,
		                                    'label' => ['text' => '']
		                                ]
		                            ],
		                        ],
		                        [
		                        	'title' => [
			                            'text' => 'Lot'
			                        ],
			                        'opposite' => true,
			                        //'gridLineDashStyle' => 'Dash',
			                        //'min' => 0,
			                        //'max' => 100,
			                        /*'plotLines' => [
		                                [
		                                    'value' => 10,
		                                    'color' => '#ff009d',
		                                    'width' => 3,
		                                    'zIndex' => 0,
		                                    'label' => ['text' => '']
		                                ]
		                            ],*/
		                        ],
		                    ],
		                    'tooltip' => [
		                        'shared' => true,
		                        'crosshairs' => true,
		                        'xDateFormat' => '%Y-%m-%d',
		                        //'valueSuffix' => '%',
		                    ],
		                    'series' => $data,
		                ],
					]);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-default box-solid">
			<div class="box-body">
				<div class="col-md-12">
					<?php
		            echo Highcharts::widget([
		                'scripts' => [
		                    //'modules/exporting',
		                    //'themes/grid-light',
		                    //'themes/sand-signika',
		                ],
		                'options' => [
		                    'chart' => [
		                        //'zoomType' => 'x',
		                        'type' => 'spline',
		                        'style' => [
		                            'fontFamily' => 'sans-serif',
		                        ],
		                        'height' => 230
		                    ],
		                    'credits' => [
		                        'enabled' =>false
		                    ],
		                    'title' => [
		                        'text' => null
		                    ],
		                    'xAxis' => [
		                        'type' => 'datetime',
		                    ],
		                    'legend' => [
		                    	'labelFormat' => 'Dandori Time - Target Max. ' . $target_max . ' min'
		                    ],
		                    'yAxis' => [
	                        	'title' => [
		                            'enabled' => true,
		                            'text' => 'Minutes',
		                        ],
		                        'plotLines' => [
		                            [
		                                'value' => $target_max,
		                                'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
		                                'width' => 1.5,
		                                'zIndex' => 0,
		                                'label' => ['text' => '']
		                            ]
		                        ],
		                        'max' => $yaxis_max,
	                        ],
		                    'tooltip' => [
		                        //'shared' => true,
		                        //'crosshairs' => true,
		                        'xDateFormat' => '%Y-%m-%d',
		                        //'valueSuffix' => '%',
		                    ],
		                    'series' => $data2
		                ],
		            ]);
		            ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php ActiveForm::end(); ?>