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
    'page_title' => 'Daily Employee Temperature <span class="japanesse light-green"></span>',
    'tab_title' => 'Daily Employee Temperature',
    'breadcrumbs_title' => 'Daily Employee Temperature'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.4em; text-align: center; display: none;}
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

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        font-size: 4em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        height: 100px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
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
    'action' => Url::to(['daily-emp-temperature']),
]); ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'section')->dropDownList($section_arr, [
            'class' => 'form-control',
            'prompt' => 'Select a section...'
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
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>
<div class="box box-primary box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Daily Employee Temperature</h3>
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
                    'type' => 'spline',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    //'height' => 600
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => null,
                    'style' => [
                        'fontSize' => '30px',
                    ],
                ],
                'subtitle' => [
                    'text' => null,
                    'style' => [
                        'fontSize' => '22px',
                    ],
                ],
                'xAxis' => [
                    'type' => 'datetime',
                ],
                'yAxis' => [
                    'tickInterval' => 1,
                    'max' => 40,
                    'min' => 0
                ],
                'plotOptions' => [
                    'spline' => [
                        'dataLabels' => [
                            'enabled' => false,
                        ],
                    ],
                    'series' => [
                        'cursor' => 'pointer',
                        'marker' => [
                            'enabled' => false
                        ],
                    ]
                ],
                'series' => $data,
            ],
        ]);
        ?>
    </div>
</div>