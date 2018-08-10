<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'Daily Container by Port <span class="text-green">(港別の出荷コンテナー)</span>',
    'tab_title' => 'Shipping Chart',
    'breadcrumbs_title' => 'Shipping Chart'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("h1 span { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");
//$color = new JsExpression('Highcharts.getOptions().colors[7]');
$color = 'CadetBlue';
$font_color = 'black';

date_default_timezone_set('Asia/Jakarta');

$this->registerCss(".tab-content > .tab-pane,
.pill-content > .pill-pane {
    display: block;     
    height: 0;          
    overflow-y: hidden; 
}

.tab-content > .active,
.pill-content > .active {
    height: auto;       
} ");

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

<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title"><?= date('d F Y', strtotime(Yii::$app->request->get('etd'))) . ' (' . $containerStr . ')'; ?></h3>
		<div class="pull-right box-tools">
			<?= '';Html::a('Back',  Url::previous(), ['class' => 'btn btn-warning btn-sm']) ?>
		</div>
	</div>
	<div class="box-body no-padding">
		<div class="row">
			<?php
			echo Highcharts::widget([
	            'scripts' => [
	                'modules/exporting',
	                'themes/sand-signika',
	                //'themes/grid-light',
	            ],
	            'options' => [
	                'chart' => [
	                    'type' => 'column',
	                    'height' => 450,
	                    'width' => null
	                ],
	                'credits' => [
	                    'enabled' =>false
	                ],
	                'title' => [
	                    'text' => 'Container Progress'
	                ],
	                'xAxis' => [
	                    'type' => 'category'
	                ],
	                'xAxis' => [
	                    'categories' => $dataName,
	                ],
	                'yAxis' => [
	                    'min' => 0,
	                    'title' => [
	                        'text' => 'Total Completion'
	                    ],
	                    'gridLineWidth' => 0,
	                ],
	                'tooltip' => [
	                    //'enabled' => false
	                ],
	                'plotOptions' => [
	                    'column' => [
	                        'stacking' => 'normal',
	                        'dataLabels' => [
	                            'enabled' => true,
	                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
	                            'style' => [
	                                //'fontSize' => '14px',
	                                'fontWeight' => '0'
	                            ],
	                        ],
	                        'borderWidth' => 2,
	                        'borderColor' => $color,
	                    ],
	                    'series' => [
	                        'cursor' => 'pointer',
	                        'point' => [
	                            'events' => [
	                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
	                                //'click' => new JsExpression('function(){ window.open(this.options.url); }')
	                            ]
	                        ]
	                    ]
	                ],
	                'series' => [
	                    [
	                        'name' => 'Outstanding',
	                        'data' => $dataOpen,
	                        'color' => 'FloralWhite',
	                        'dataLabels' => [
	                            'enabled' => true,
	                            'color' => $font_color,
	                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
	                            'style' => [
	                                'textOutline' => '0px'
	                            ],
	                        ],
	                        //'showInLegend' => false
	                    ],
	                    [
	                        'name' => 'Completed',
	                        'data' => $dataClose,
	                        'color' => $color,
	                        'dataLabels' => [
	                            'enabled' => true,
	                            'color' => $font_color,
	                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
	                            'style' => [
	                                'textOutline' => '0px'
	                            ],
	                        ]
	                    ]
	                ]
	            ],
	        ]);
			?>
		</div>
	</div>
</div>