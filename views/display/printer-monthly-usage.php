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
    'page_title' => 'Paper Used (This Month)',
    'tab_title' => 'Paper Used (This Month)',
    'breadcrumbs_title' => 'Paper Used (This Month)'
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
      setTimeout(\"refreshPage();\", 60000); // milliseconds
    }
    function refreshPage() {
       window.location = '" . Url::to(['display/printer-usage']) . "';
    }

    function animation_page(){
        loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 700, easingIn : mina.easeinout } ); //------------------- ANIMASI -------------------------
        function init() //------------------- ANIMASI -------------------------
        { //------------------- ANIMASI -------------------------
            loader.show(); //------------------- ANIMASI -------------------------
            setTimeout( function() { loader.hide(); }, 700 ); //------------------- ANIMASI -------------------------
        } //------------------- ANIMASI -------------------------

        init(); //------------------- ANIMASI -------------------------
    };
    $(document).ready(function() {
        animation_page();
    });
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
$total_plan = $total_act = $total_balance = 0;
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['daily-prod-schedule']),
]); ?>
<div id="pagewrap" class="pagewrap">
    <div class="container show">
        <div class="row" style="display: none;">
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
                <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
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
                                'text' => 'Total Paper Used',
                            ],
                            'xAxis' => [
                                'categories' => $categories,
                                'gridLineWidth' => 0
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Total Paper Used (PCS)',
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
                            'series' => $data,
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
                                'text' => 'Total Different Use With Last Month',
                            ],
                            'xAxis' => [
                                'categories' => $categories,
                                'gridLineWidth' => 0
                            ],
                            'yAxis' => [
                                'title' => [
                                    'text' => 'Total Different (PCS)',
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
                            'series' => $data2,
                        ],
                    ]);

                    ?>
            </div>
        </div>

    </div>
    <div id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z"> <!------------------- ANIMASI ------------------------->
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none" > <!------------------- ANIMASI ------------------------->
            <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/> <!------------------- ANIMASI ------------------------->
        </svg> <!------------------- ANIMASI ------------------------->
    </div>
</div>
