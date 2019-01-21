<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

$this->title = [
    'page_title' => '',
    'tab_title' => 'SMT Dandori',
    'breadcrumbs_title' => 'SMT Dandori'
];

$this->registerCss("
	.japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	.content-wrapper {background-color: #33383D;}
	.content-header {color: white;}
	.form-control {background-color: #33383D; color: rgb(255, 235, 59); border-color: #33383D;}
	.box-title {font-weight: bold;}
	.box-header .box-title{font-size: 20px;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em}
	body {background-color: #33383D;}
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
	<div class="col-md-4">
		<div class="box box-default box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Line</h3>
			</div>
			<div class="box-body">
		        <?= Html::dropDownList('line', $line, [
		        	'01' => '01',
		        	'02' => '02',
		        ], [
		            'class' => 'form-control',
		            'onchange'=>'this.form.submit()',
		            'style' => 'height: 50px; padding: 3px 12px; font-size:2em;'
		        ]); ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-default box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Year</h3>
			</div>
			<div class="box-body">
		        <?= Html::dropDownList('year', $year, \Yii::$app->params['year_arr'], [
		            'class' => 'form-control',
		            'onchange'=>'this.form.submit()',
		            'style' => 'height: 50px; padding: 3px 12px; font-size:2em;'
		        ]); ?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-default box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Month</h3>
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
		            'style' => 'height: 50px; padding: 3px 12px; font-size:2em;'
		        ]); ?>
			</div>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>

<div class="row">
	<div class="col-md-12">
		<div class="box box-default box-solid">
			<div class="box-header with-border">
				<!--<h3 class="box-title">Dandori Utilization</h3>-->
			</div>
			<div class="box-body">
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
	                        'height' => 400
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
		                            'text' => 'Percentage (%)'
		                        ],
		                        'gridLineDashStyle' => 'Dash',
		                        'min' => 0,
		                        //'max' => 100,
		                        'plotLines' => [
	                                [
	                                    'value' => 10,
	                                    'color' => '#ff009d',
	                                    'width' => 3,
	                                    'zIndex' => 0,
	                                    'label' => ['text' => '']
	                                ]
	                            ],
	                        ],
	                        [
	                        	'title' => [
		                            'text' => 'pcs'
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