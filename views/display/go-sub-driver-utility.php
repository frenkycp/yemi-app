<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'GO Sub Assy Driver Utility <span class="japanesse light-green"></span>',
    'tab_title' => 'GO Sub Assy Driver Utility',
    'breadcrumbs_title' => 'GO Sub Assy Driver Utility'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
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
    h3, h5 {opacity: 0.9;}

    #progress-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #progress-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #595F66;
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #progress-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 28px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
    }
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data);
echo '</pre>';*/

?>

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
            //'height' => 500
        ],
        'title' => [
            'text' => null
        ],
        'subtitle' => [
            'text' => ''
        ],
        'xAxis' => [
            //'type' => 'datetime',
            'categories' => $categories,
        ],
        'yAxis' => [
            /*'stackLabels' => [
                'enabled' => true
            ],*/
            //'min' => 0,
            'title' => [
                'text' => 'Utility (%)'
            ],
            'max' => 100
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
            'column' => [
                //'stacking' => 'normal',
                'dataLabels' => [
                    'enabled' => true,
                    //'format' => '{point.percentage:.0f}% ({point.qty:.0f})',
                    //'color' => 'black',
                    //'formatter' => new JsExpression('function(){ if(this.y != 0) { return this.y; } }'),
                    /*'style' => [
                        'textOutline' => '0px',
                        'fontWeight' => '0'
                    ],*/
                ],
                //'borderWidth' => 1,
                //'borderColor' => $color,
            ],
            'series' => [
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