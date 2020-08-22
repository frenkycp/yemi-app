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
    'page_title' => 'Phone Daily Usage',
    'tab_title' => 'Phone Daily Usage',
    'breadcrumbs_title' => 'Phone Daily Usage'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCssFile('@web/css/component.css');
$this->registerJsFile('@web/js/snap.svg-min.js');
$this->registerJsFile('@web/js/classie.js');
$this->registerJsFile('@web/js/svgLoader.js');

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; text-align: center;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    .content-header>h1 {font-size: 2.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .form-horizontal .control-label {padding-top: 0px;}
    .myTable {font-size: 1em; color: white; letter-spacing: 1px;}
    //.myTable > tbody > tr:nth-child(odd) > td {background-color: #2f2f2f; color: white;}
    //.myTable > tbody > tr:nth-child(even) > td {background-color: #121213; color: white;}
    .myTable > thead > tr > th {background-color: #61258e; color: #ffeb3b;}
    .myTable > tbody > tr > td {font-size: 0.8em;}
    .dataTables_wrapper {color: white;}
    .table-title {font-size: 1.5em;}
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

/*$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#myTable').DataTable({
        'pageLength': 15,
        'order': [[ 0, 'desc' ]]
    });
});");*/

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['pabx-daily-usage']),
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
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<br/>
<div class="box box-primary box-solid">
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                //'themes/grid-light',
                'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'zoomType' => 'x',
                    'height' => 350
                ],
                'title' => [
                    //'text' => 'Plan Qty V.S Actual Qty (Monthly Based)'
                ],
                'subtitle' => [
                    'text' => ''
                ],
                'xAxis' => [
                    'type' => 'datetime',
                    //'categories' => $value['category'],
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Total Minute(s)'
                    ],
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            'textOutline' => 'unset',
                            'color' => 'white',
                        ]
                    ],
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    //'xDateFormat' => '%A, %b %e %Y',
                    'valueSuffix' => ' minute(s)'
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'column' => [
                        'stacking' => 'normal'
                    ],
                    'series' => [
                        'marker' => [
                            'enabled' => false
                        ],
                        'dataLabels' => [
                            'enabled' => true
                        ],
                        /*'lineWidth' => 1,
                        'marker' => [
                            'radius' => 2,
                        ],*/
                        'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression("
                                    function(e){
                                        e.preventDefault();
                                        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                                    }
                                "),
                            ]
                        ]
                    ]
                ],
                'series' => $data
            ],
        ]);
        ?>
    </div>
</div>

<div class="box box-primary box-solid">
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                //'themes/grid-light',
                'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'zoomType' => 'x',
                    'height' => 350
                ],
                'title' => [
                    'text' => 'Top (50) Call Duration'
                ],
                'subtitle' => [
                    'text' => ''
                ],
                'xAxis' => [
                    'categories' => $call_categories,
                    'labels' => [
                        'enabled' => false
                    ],
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Total Minute(s)'
                    ],
                    'stackLabels' => [
                        'enabled' => true,
                        'style' => [
                            'textOutline' => 'unset',
                            'color' => 'white',
                        ]
                    ],
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    //'xDateFormat' => '%A, %b %e %Y',
                    'valueSuffix' => ' minute(s)'
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'series' => [
                        'marker' => [
                            'enabled' => false
                        ],
                        'dataLabels' => [
                            'enabled' => true
                        ],
                        /*'lineWidth' => 1,
                        'marker' => [
                            'radius' => 2,
                        ],*/
                        /*'cursor' => 'pointer',
                        'point' => [
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
                'series' => $data_call
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