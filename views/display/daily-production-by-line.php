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
    'page_title' => 'Daily Production by Line',
    'tab_title' => 'Daily Production by Line',
    'breadcrumbs_title' => 'Daily Production by Line'
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
        //animation_page();
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
    'action' => Url::to(['daily-production-by-line']),
]); ?>
<div id="pagewrap" class="pagewrap">
    <div class="container show">
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
            <div class="col-md-3">
                <?= $form->field($model, 'line')->dropDownList(
                    $line_arr,
                    [
                        'prompt' => 'Choose...',
                    ]
                ); ?>
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
                        //'themes/sand-signika',
                        //'themes/grid-light',
                        'themes/dark-unica',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'line',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            //'height' => 800
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
                            //'min' => 0,
                            'title' => [
                                'text' => null
                            ],
                            'stackLabels' => [
                                'enabled' => true
                            ],
                            'allowDecimals' => false,
                            //'gridLineWidth' => 0,
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'tooltip' => [
                            'enabled' => true,
                            //'xDateFormat' => '%A, %b %e %Y',
                            //'valueSuffix' => ' min'
                            //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                        ],
                        'plotOptions' => [
                            'series' => [
                                'marker' => [
                                    'enabled' => false
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
                        'series' => $data
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
