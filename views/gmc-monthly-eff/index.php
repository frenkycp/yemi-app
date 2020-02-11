<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use miloschuman\highcharts\Highcharts;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ProdPlanDataSearch $searchModel
*/

$this->title = [
    'page_title' => 'GMC Monthly Efficiency (Total) <span class="japanesse text-green"></span>',
    'tab_title' => 'GMC Monthly Efficiency (Total)',
    'breadcrumbs_title' => 'GMC Monthly Efficiency (Total)'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['gmc-monthly-eff/index']),
]); ?>

<div class="row">
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
    <div class="col-md-2">
        <?= $form->field($model, 'gmc')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(app\models\SernoMaster::find()->select([
                'gmc', 'model', 'color', 'dest'
            ])
            ->all(), 'gmc', 'fullDescription'),
            'options' => [
                'placeholder' => 'Choose...',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="panel panel-primary">
	<div class="panel-body">
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
                    'type' => 'line',
                    'style' => [
                        //'fontFamily' => 'Source Sans Pro'
                    ],
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => null
                ],
                'legend' => [
                    'enabled' => false,
                ],
                'xAxis' => [
                    'categories' => $categories,
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Percentage (%)'
                    ],
                ],
                'tooltip' => [
                    //'shared' => true,
                    //'crosshairs' => true,
                    //'xDateFormat' => '%Y-%m-%d',
                    //'valueSuffix' => ' minutes',
                ],
                'plotOptions' => [
                    'line' => [
                        'dataLabels' => [
                            'enabled' => true
                        ],
                        'maxPointWidth' => 100,
                    ],
                ],
                'series' => $data,
            ],
        ]); ?>
	</div>
</div>