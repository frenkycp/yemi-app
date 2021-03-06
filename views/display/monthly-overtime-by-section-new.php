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
    'page_title' => 'OT Management by Section <span class="japanesse light-green">(部門別残業管理）</span>',
    'tab_title' => 'OT Management by Section',
    'breadcrumbs_title' => 'OT Management by Section'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.8em;}
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
    a {
        color: yellow;
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
    'action' => Url::to(['monthly-overtime-by-section-new']),
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
        <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-user"></i> Last Update : <?= date('Y-m-d H:i:s'); ?> <span style="color: yellow;">(For Old Data Click <u><?= Html::a('Here', ['monthly-overtime-by-section']); ?></u>)</span></h3>
    </div>
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/grid-light',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'spline',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'height' => 500
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => $model->section,
                ],
                'subtitle' => [
                    'text' => null,
                ],
                'xAxis' => [
                    'categories' => $categories,
                    'labels' => [
                        'style' => [
                            'fontSize' => '20px',
                            'fontWeight' => 'bold'
                        ],
                    ],
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'HOURS'
                    ],
                    'min' => 0,
                    'max' => 100,
                    'plotLines' => [
                        [
                            'value' => 10,
                            'color' => 'orange',
                            'dashStyle' => 'shortdash',
                            'width' => 2,
                            'label' => [
                                'text' => 'NORMAL (10)',
                                'align' => 'left',
                            ],
                            //'zIndex' => 5
                        ], [
                            'value' => 20,
                            'color' => 'red',
                            'dashStyle' => 'shortdash',
                            'width' => 2,
                            'label' => [
                                'text' => 'MAXIMUM (20)',
                                'align' => 'left',
                            ],
                            //'zIndex' => 5
                        ]
                    ]
                ],
                'plotOptions' => [
                    'spline' => [
                        'dataLabels' => [
                            'enabled' => true,
                        ],
                    ],
                    'series' => [
                        //'cursor' => 'pointer',
                        'marker' => [
                            'enabled' => false
                        ],
                        'dataLabels' => [
                            //'allowOverlap' => true
                            //'enabled' => true
                        ],
                        /*'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]*/
                    ]
                ],
                'series' => $data,
            ],
        ]);
        ?>
    </div>
</div>
<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>