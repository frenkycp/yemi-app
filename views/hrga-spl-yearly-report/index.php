<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'SPL Report Yearly <span class="japanesse text-green"></span>',
    'tab_title' => 'SPL Report Yearly',
    'breadcrumbs_title' => 'SPL Report Yearly'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse {
        font-family: 'MS PGothic', Osaka, Arial, sans-serif;
    }
");

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

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<div class="box box-primary">
	<div class="box-body">
		<?php
        echo Highcharts::widget([
        	'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
            ],
            'options' => [
            	'chart' => [
            		'type' => 'column',
            		'height' => 500,
            		//'zoomType' => 'x',
            	],
            	'xAxis' => [
            		'categories' => $categories
            	],
            	'yAxis' => [
            		'stackLabels' => [
            			'enabled' => true,
            		],
            		'title' => [
            			'text' => 'HOURS'
            		],
            	],
            	'credits' => [
            		'enabled' => false
            	],
            	'title' => [
            		'text' => null
            	],
            	'plotOptions' => [
            		'column' => [
            			'stacking' => 'normal'
            		]
            	],
            	'series' => $data
            ],
        ]);
        ?>
	</div>
</div>