<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

if ($type == 1) {
    $this->title = [
        'page_title' => 'Training Daily Report',
        'tab_title' => 'Training Daily Report',
        'breadcrumbs_title' => 'Training Daily Report'
    ];
} else {
    $this->title = [
        'page_title' => 'Total NG V.S Re-Training',
        'tab_title' => 'Total NG V.S Re-Training',
        'breadcrumbs_title' => 'Total NG V.S Re-Training'
    ];
}

//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .tab-content > .tab-pane,
    .pill-content > .pill-pane {
        display: block;     
        height: 0;          
        overflow-y: hidden; 
    }

    .tab-content > .active,
    .pill-content > .active {
        height: auto;
    }
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
    'action' => Url::to(['training-daily-report', 'type' => $type]),
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
        <?= $form->field($model, 'location')->dropDownList(\Yii::$app->params['wip_location_arr'], [
            'prompt' => 'Choose...'
        ]); ?>
    </div>
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-success', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<br/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-body">
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
                            'type' => 'column',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'zoomType' => 'x',
                            //'height' => 300,
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
                                'text' => 'Total',
                            ],
                            'stackLabels' => [
                                'enabled' => true,
                            ],
                            'allowDecimals' => false,
                            //'max' => 60,
                            //'tickInterval' => 10
                        ],
                        'tooltip' => [
                            'enabled' => true,
                            'shared' => true,
                            //'valueSuffix' => '%'
                        ],
                        'plotOptions' => [
                            'series' => [
                                'lineWidth' => 1,
                                //'showInLegend' => false,
                                //'color' => new JsExpression('Highcharts.getOptions().colors[0]')
                            ],
                        ],
                        'series' => $data_training,
                    ],
                ]);

                ?>
            </div>
        </div>
    </div>
</div>