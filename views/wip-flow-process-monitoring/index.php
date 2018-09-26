<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\web\View;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'E-WIP Process-Flow Monitor <span class="japanesse text-green">（E-WIP 工程流れモニター）</span>',
    'tab_title' => 'E-WIP Process-Flow Monitor',
    'breadcrumbs_title' => 'E-WIP Process-Flow Monitor'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

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

date_default_timezone_set('Asia/Jakarta');

/* echo '<pre>';
print_r($categories);
echo '</pre>'; */

?>

<?php $form = ActiveForm::begin([
	'method' => 'get',
	'action' => Url::to(['wip-flow-process-monitoring/index']),
]); ?>

<div class="row">
	<div class="col-sm-2">
		<?= $form->field($model, 'model')->dropDownList(
			ArrayHelper::map(app\models\WipFlowView02::find()->select('distinct(model_group)')->orderBy('model_group')->all(), 'model_group', 'model_group'),
			[
				'onchange'=>'$("#flowprocessfiltermodel-gmc").val(null)',
				'prompt' => 'Select model...'
			]
		) ?>
	</div>
	<div class="col-sm-2">
		<?= $form->field($model, 'gmc')->dropDownList(
			ArrayHelper::map(app\models\WipFlowView02::find()->select('distinct(parent)')->orderBy('parent')->all(), 'parent', 'parent'),
			[
				'onchange'=>'$("#flowprocessfiltermodel-model").val(null)',
				'prompt' => 'Select GMC...'
			]
		) ?>
	</div>
</div>

<div class="form-group">
	<?= Html::submitButton('Update Chart', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
<p><b>Last Update : <?= date('d M Y H:i'); ?></b></p>
<?php
echo Highcharts::widget([
	'scripts' => [
		'highcharts-more',
		//'modules/exporting',
		'modules/xrange',
        'themes/grid',
        //'themes/sand-signika',


	],
	'options' => [
		'chart' => [
            'type' => 'xrange',
            'height' => 1000
        ],
        'title' => [
	        'text' => null
	    ],
	    'credits' => [
	    	'enabled' => false
	    ],
	    'xAxis' => [
	        'type' => 'datetime'
	    ],
	    'yAxis' => [
	        'title' => [
	            'text' => ''
	        ],
	        'categories' => $categories,
	        'reversed' => true,
	    ],
	    'series' => $data
	],
]);
?>