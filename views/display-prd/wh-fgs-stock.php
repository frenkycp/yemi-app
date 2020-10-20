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
    'page_title' => 'WH FGS Stock',
    'tab_title' => 'WH FGS Stock',
    'breadcrumbs_title' => 'WH FGS Stock'
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
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
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

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
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
                'height' => 400
            ],
            'title' => [
                'text' => 'Total Amount by ETD'
            ],
            'subtitle' => [
                'text' => null
            ],
            'xAxis' => [
                'type' => 'datetime',
                //'categories' => $value['category'],
            ],
            'yAxis' => [
                'title' => [
                    'text' => 'Total Amount'
                ],
            ],
            'credits' => [
                'enabled' =>false
            ],
            'tooltip' => [
                'enabled' => true,
                //'xDateFormat' => '%A, %b %e %Y',
                //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
            ],
            'plotOptions' => [
                'series' => [
                    'dataLabels' => [
                        'enabled' => true
                    ],
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
            'series' => $data_by_etd
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
                        'height' => 400,
                        //'zoomType' => 'x'
                    ],
                    'credits' => [
                        'enabled' => false
                    ],
                    'title' => [
                        'text' => 'Total Amount by Destination',
                    ],
                    'xAxis' => [
                        'categories' => $dst_category,
                        'gridLineWidth' => 0
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => 'Total Amount',
                        ],
                        //'max' => 60,
                        //'tickInterval' => 10
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        //'valueSuffix' => '%',
                        'shared' => true,
                    ],
                    'plotOptions' => [
                        'column' => [
                            //'pointPadding' => 0.1,
                            'borderWidth' => 0
                        ],
                        'series' => [
                            'dataLabels' => [
                                'enabled' => true,
                                //'format' => '{point.y:,.0f}',
                            ],
                            'turboThreshold' => 0
                        ],
                    ],
                    'series' => $data_by_dst,
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