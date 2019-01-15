<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'One Job Completion Time (AVG) <span class="japanesse text-green"></span> | GO-WIP',
    'tab_title' => 'One Job Completion Time (AVG)',
    'breadcrumbs_title' => 'One Job Completion Time (AVG)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("h1 .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['gojek-driver-avg-completion/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Year'); ?>
        <?= Html::dropDownList('year', $year, \Yii::$app->params['year_arr'], [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
    <div class="col-md-2">
        <?= Html::label('Month'); ?>
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
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
</div>
<br/>

<?php ActiveForm::end(); ?>
<div class="box box-primary box-solid">
	<div class="box-header with-border">
		<h3 class="box-title">
			<i class="fa fa-tag"></i>
			 Last Update : <?= date('Y-m-d H:i'); ?>
		</h3>
	</div>
	<div class="box-body">
		<?php
		echo Highcharts::widget([
		    'scripts' => [
		        //'modules/exporting',
		        'themes/grid-light',
		        //'themes/sand-signika',
		        //'themes/dark-unica',
		    ],
		    'options' => [
		        'chart' => [
		            'type' => 'column',
		        ],
		        'title' => [
		            'text' => null
		        ],
		        'subtitle' => [
		            'text' => null
		        ],
		        'credits' => [
		            'enabled' => false
		        ],
		        'legend' => [
		            'enabled' => false
		        ],
		        'xAxis' => [
		            'categories' => $categories
		        ],
		        'yAxis' => [
		            'min' => 0,
		            'allowDecimals' => false,
		            'title' => [
		                'text' => 'Minute',
		                //'align' => 'high'
		            ],
		            'labels' => [
		                'overflow' => 'justify'
		            ]
		        ],
		        'tooltip' => [
                    'valueSuffix' => ' minutes',
                ],
		        'plotOptions' => [
		        	'series' => [
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]
                    ],
		            'column' => [
		                'dataLabels' => [
		                    'enabled' => true,
		                    'format' => '{point.y}'
		                ]
		            ],
		            
		        ],
		        'series' => $data
		    ],
		]);
		?>
		<?php
        yii\bootstrap\Modal::begin([
            'id' =>'modal',
            'header' => '<h3>Detail Information</h3>',
            'size' => 'modal-lg',
        ]);
        yii\bootstrap\Modal::end();
        ?>
	</div>
</div>
