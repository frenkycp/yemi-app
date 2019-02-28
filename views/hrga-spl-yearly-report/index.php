<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Overtime Monthly Monitor <span class="japanesse text-green">（月次残業モニター)</span>',
    'tab_title' => 'Overtime Monthly Monitor',
    'breadcrumbs_title' => 'Overtime Monthly Monitor'
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

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['hrga-spl-yearly-report/index']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= Html::label('Fiscal'); ?>
        <?= Html::dropDownList('fiscal', $fiscal, ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->limit(10)->all(), 'FISCAL', 'FISCAL'), [
            'class' => 'form-control',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i:s') ?></h3>
    </div>
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
            		'height' => 450,
            		//'zoomType' => 'x',
            	],
            	'xAxis' => [
            		'categories' => $categories
            	],
            	'yAxis' => [
            		'stackLabels' => [
            			'enabled' => true,
                        'rotation' => -90,
                        'y' => -15
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
            			'stacking' => 'normal',
                        'events' => [
                            'legendItemClick' => new JsExpression('
                                function(){
                                    return false;
                                }
                            '),
                        ]
            		]
            	],
            	'series' => $data_final
            ],
        ]);
        ?>
	</div>
</div>