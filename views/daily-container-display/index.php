<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'DAILY CONTAINER BY PORT <span class="japanesse light-green">(港別の出荷コンテナー)</span>',
    'tab_title' => 'DAILY CONTAINER BY PORT',
    'breadcrumbs_title' => 'DAILY CONTAINER BY PORT'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

//$color = new JsExpression('Highcharts.getOptions().colors[7]');
$color = 'rgba(0, 255, 0, 0.7)';
$font_color = 'black';

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold; font}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}

    #clinic-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #clinic-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #858689;
        color: white;
        font-size: 22px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #clinic-tbl > tbody > tr > td{
        //border:1px solid #29B6F6;
        font-size: 16px;
        background-color: #B3E5FC;
        font-weight: 1000;
        color: #555;
        vertical-align: middle;
    }
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
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

?>

<div class="box box-default box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><?= date('d F Y', strtotime($etd)) . ' (' . $containerStr . ') - Last Update : ' . date('Y-m-d H:i'); ?></h3>
		<div class="pull-right box-tools">
			<?= '';Html::a('Back',  Url::previous(), ['class' => 'btn btn-warning btn-sm']) ?>
		</div>
	</div>
	<div class="box-body">
		<?php
		echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 750,
                    'width' => null,
                    'style' => [
                        'fontFamily' => 'Source Sans Pro'
                    ],
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => null
                ],
                'xAxis' => [
                    'categories' => $dataName,
                    'labels' => [
                    	'style' => [
                    		'fontSize' => '20px',
                    		'fontWeight' => 'bold'
                    	],
                    ],
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
                        'stacking' => 'percent',
                        'dataLabels' => [
                            'enabled' => true,
                            //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                            'style' => [
                                'fontSize' => '20px',
                                'fontWeight' => '0'
                            ],
                        ],
                        'borderWidth' => 2,
                        'borderColor' => 'rgba(0, 255, 0)',
                    ],
                    'series' => [
                        /*'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                            ]
                        ]*/
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
                        'showInLegend' => false
                    ],
                    [
                        'name' => 'Completed',
                        'data' => $dataClose,
                        'color' => new JsExpression('Highcharts.getOptions().colors[7]'),
                        'dataLabels' => [
                            'enabled' => true,
                            'color' => $font_color,
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                            'style' => [
                                'textOutline' => '0px'
                            ],
                        ],
                        'showInLegend' => false
                    ]
                ]
            ],
        ]);
		?>
	</div>
</div>