<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'Audit Patrol Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Audit Patrol Monitoring',
    'breadcrumbs_title' => 'Audit Patrol Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['audit-patrol-monitoring']),
]); ?>

<div class="row" style="">
    <div class="col-md-4">
        <?php echo '<label class="control-label">Select date range</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'from_date',
            'attribute2' => 'to_date',
            'options' => ['placeholder' => 'Start date'],   
            'options2' => ['placeholder' => 'End date'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>

<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-primary">
			<div class="panel-body">
				<?=
                Highcharts::widget([
                    'scripts' => [
                        //'modules/exporting',
                        //'themes/sand-signika',
                        'themes/grid-light',
                        'highcharts-3d',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'pie',
                            'options3d' => [
					            'enabled' => true,
					            'alpha' => 45,
					            'beta' => 0
					        ],
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'height' => '300',
                            'plotBackgroundColor' => null,
                            'plotBorderWidth' => null,
                            'plotShadow' => false,
                        ],
                        'title' => [
                            'text' => 'Total Audit by Status'
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'tooltip' => [
                            //'pointFormat' => '{series.name}: <b>{point.percentage:.2f}% ({point.y})</b>',
                        ],
                        'plotOptions' => [
                            'pie' => [
                                // 'allowPointSelect' => true,
                                // 'cursor' => 'pointer',
                                'depth' => 35,
                                'dataLabels' => [
                                    'enabled' => true,
                                    'format' => '<b>{point.name}</b>: {point.percentage:.1f}% ({point.y})'
                                ],
                            ],
                            /*'series' => [
                                'cursor' => 'pointer',
                                'point' => [
                                    'events' => [
                                        'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    ]
                                ]
                            ],*/
                        ],
                        'series' => $data['status']
                    ],
                ]);
                ?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-primary">
			<div class="panel-body">
				<?=
                Highcharts::widget([
                    'scripts' => [
                        //'modules/exporting',
                        //'themes/sand-signika',
                        'themes/grid-light',
                        'highcharts-3d',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'pie',
                            'options3d' => [
					            'enabled' => true,
					            'alpha' => 45,
					            'beta' => 0
					        ],
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'height' => '300',
                            'plotBackgroundColor' => null,
                            'plotBorderWidth' => null,
                            'plotShadow' => false,
                        ],
                        'title' => [
                            'text' => 'Total Audit by Category'
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'tooltip' => [
                            //'pointFormat' => '{series.name}: <b>{point.percentage:.2f}% ({point.y})</b>',
                        ],
                        'plotOptions' => [
                            'pie' => [
                                // 'allowPointSelect' => true,
                                // 'cursor' => 'pointer',
                                'depth' => 35,
                                'dataLabels' => [
                                    'enabled' => true,
                                    'format' => '<b>{point.name}</b>: {point.percentage:.1f}% ({point.y})'
                                ],
                            ],
                            /*'series' => [
                                'cursor' => 'pointer',
                                'point' => [
                                    'events' => [
                                        'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                                    ]
                                ]
                            ],*/
                        ],
                        'series' => $data['topic']
                    ],
                ]);
                ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Daily Report Status</h3>
			</div>
			<div class="panel-body">
				<?=
		        Highcharts::widget([
		            'scripts' => [
		                'highcharts-more',
		                //'modules/exporting',
		                //'themes/sand-signika',
		                'modules/solid-gauge',
		                //'themes/dark-unica',
		            ],
		            'options' => [
		                'chart' => [
		                    'type' => 'column',
		                    //'height' => '500',
		                    'style' => [
		                        'fontFamily' => 'sans-serif',
		                    ],
		                    'zoomType' => 'x'
		                ],
		                'title' => [
		                    'text' => null,
		                ],
		                'xAxis' => [
		                    'type' => 'datetime',
		                    //'lineWidth' => 1,
		                ],
		                'yAxis' => [
		                    'minorGridLineWidth' => 0,
		                    'title' => [
		                        'text' => null,
		                    ],
		                    'allowDecimals' => false,
		                    /*'stackLabels' => [
		                        'enabled' => true,
		                    ],*/
		                    //'min' => 0,
		                    //'tickInterval' => 20
		                ],
		                'legend' => [
		                    'enabled' => true,
		                ],
		                'credits' => [
		                    'enabled' => false
		                ],
		                'tooltip' => [
		                    'enabled' => true,
		                    //'valueSuffix' => ' ' . $um,
		                    'shared' => true,
		                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
		                ],
		                'plotOptions' => [
		                    'column' => [
		                        'stacking' => 'normal',
		                        'marker' => [
		                            'enabled' => false
		                        ],
		                        'dataLabels' => [
		                            'enabled' => true,
		                        ],
		                    ],
		                    
		                ],
		                'series' => $data['status_daily'],
		            ],
		        ]);
		        ?>
			</div>
		</div>
	</div>
</div>