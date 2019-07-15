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
    'page_title' => 'FGS Stock <span class="japanesse text-green"></span>',
    'tab_title' => 'FGS Stock',
    'breadcrumbs_title' => 'FGS Stock'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
");

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data);
echo '</pre>';*/

?>

<div class="box box-primary">
    <div class="box-header">
        <h5 class="box-title"><i class="fa fa-tag"></i> Last Update : <?= date('Y-m-d H:i') ?></h5>
    </div>
    <div class="box-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                //'themes/sand-signika',
                'themes/grid-light',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'height' => 500
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
                        'text' => 'Total Product'
                    ],
                    //'gridLineWidth' => 0,
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'tooltip' => [
                    'enabled' => true,
                    'xDateFormat' => '%A, %b %e %Y',
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
                    /*'series' => [
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
                    ]*/
                ],
                'series' => $data
            ],
        ]);
        ?>
    </div>
</div>