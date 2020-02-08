<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => 'Noise Data Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Noise Data Monitoring',
    'breadcrumbs_title' => 'Noise Data Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
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

date_default_timezone_set('Asia/Jakarta');

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
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['noise-chart']),
]); ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'map_no')->dropDownList(ArrayHelper::map(app\models\SensorTbl::find()->orderBy('location, area')->all(), 'map_no', 'locationArea'), [
            'class' => 'form-control',
            'prompt' => 'Select a location...'
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
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="box box-primary box-solid">
    <div class="box-body">
        <div class="col-md-12">
            <?php
            echo Highcharts::widget([
                'scripts' => [
                    //'modules/exporting',
                    //'themes/grid-light',
                    'themes/dark-unica',
                    //'themes/sand-signika',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'line',
                        'style' => [
                            'fontFamily' => 'sans-serif',
                        ],
                        'height' => 350,
                        'zoomType' => 'x'
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => null,
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        'gridLineWidth' => 0
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'NOISE',
                        ],
                        'max' => 100,
                        'min' => 0,
                        /*'plotBands' => [
                            [
                                'from' => $sensor_data->temp_min,
                                'to' => $sensor_data->temp_max,
                                'color' => 'rgba(76, 187, 23, 1)',
                                'label' => [
                                    'text' => 'Normal Temperature',
                                    'style' => [
                                        'color' => 'black'
                                    ],
                                    //'align' => 'center'
                                ],
                            ],
                        ],*/
                        'plotLines' => [
                            [
                                'color' => 'red',
                                'dashStyle' => 'longdashdot',
                                'value' => $sensor_data->noise_max,
                                'width' => 1,
                                'label' => [
                                    'text' => 'MAX',
                                    'align' => 'right',
                                    'style' => [
                                        'color' => '#white'
                                    ]
                                ],
                                'zIndex' => 1,
                            ]
                        ],
                        'tickInterval' => 10
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'valueSuffix' => ' db'
                    ],
                    'plotOptions' => [
                        'line' => [
                            'marker' => [
                                'enabled' =>false
                            ],
                        ],
                    ],
                    'series' => $data['noise'],
                ],
            ]);

            ?>
        </div>
    </div>
</div>

