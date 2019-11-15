<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

$this->title = [
    'page_title' => 'Monthly Dandori Monitor <span class="japanesse text-green"></span>',
    'tab_title' => 'Monthly Dandori Monitor',
    'breadcrumbs_title' => 'Monthly Dandori Monitor'
];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
");

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data);
echo '</pre>';*/

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['smt-monthly-dandori']),
]); ?>

<div class="row">
	<div class="col-md-3">
		<?= $form->field($model, 'location')->dropDownList([
		    	'WM03' => 'SMT',
		    	'WI02' => 'INJ LARGE',
		    	'WI01' => 'INJ SMALL',
		    	'WM02' => 'PCB AUTO INS.',
		    ], [
            'class' => 'form-control',
            'prompt' => 'Select location ...'
        ]); ?>
	</div>
    <div class="col-md-3">
        <?= $form->field($model, 'line')->dropDownList([
        	'01' => '01',
	    	'02' => '02',
        ], [
            'class' => 'form-control',
        ]); ?>
    </div>
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
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

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
		                    'themes/dark-unica',
		                ],
		                'options' => [
		                    'chart' => [
		                        //'zoomType' => 'x',
		                        'type' => 'line',
		                        'style' => [
		                            'fontFamily' => 'sans-serif',
		                        ],
		                        'height' => 300
		                    ],
		                    'credits' => [
		                        'enabled' =>false
		                    ],
		                    'title' => [
		                        'text' => null
		                    ],
		                    'xAxis' => [
		                        'categories' => $categories,
		                    ],
		                    'yAxis' => [
		                        [
		                        	'title' => [
			                            'text' => 'Dandori (%)'
			                        ],
			                        'gridLineDashStyle' => 'Dash',
			                        'min' => 0,
			                        //'max' => 100,
			                        /*'plotLines' => [
		                                [
		                                    'value' => 10,
		                                    'color' => 'orange',
		                                    'width' => 2,
		                                    'zIndex' => 0,
		                                    'label' => ['text' => '']
		                                ]
		                            ],*/
		                        ],
		                        [
		                        	'title' => [
			                            'text' => 'Lot'
			                        ],
			                        'opposite' => true,
		                        ],
		                    ],
		                    'tooltip' => [
		                        'shared' => true,
		                        'crosshairs' => true,
		                        //'xDateFormat' => '%Y-%m-%d',
		                        //'valueSuffix' => '%',
		                    ],
		                    'series' => $data
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
		                        'height' => 300
		                    ],
		                    'credits' => [
		                        'enabled' =>false
		                    ],
		                    'title' => [
		                        'text' => null
		                    ],
		                    'xAxis' => [
		                        'categories' => $categories,
		                    ],
		                    'legend' => [
		                    	'labelFormat' => 'Dandori Time - Target Max. ' . $target_max . ' min'
		                    ],
		                    'yAxis' => [
	                        	'title' => [
		                            'enabled' => true,
		                            'text' => 'Minutes',
		                        ],
		                        /*'plotLines' => [
		                            [
		                                'value' => $target_max,
		                                'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
		                                'width' => 1.5,
		                                'zIndex' => 0,
		                                'label' => ['text' => '']
		                            ]
		                        ],
		                        'max' => $yaxis_max,*/
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