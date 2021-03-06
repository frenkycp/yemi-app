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
    'page_title' => 'Stock Taking Progress  <span class="japanesse light-green">棚卸進捗管理</span>',
    'tab_title' => 'Stock Taking Progress ',
    'breadcrumbs_title' => 'Stock Taking Progress '
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .badge {font-weight: normal;}

    #summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 12px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: white !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    #summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: yellow;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    #yesterday-tbl > tbody > tr > td{
        border:1px solid #777474;
        background: #000;
        color: #FFF;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 2px;
        //height: 100px;
    }
    #popup-tbl > tfoot > tr > td {
        font-weight: bold;
        background-color: rgba(0, 0, 150, 0.3);
    }
    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    #summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

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
$total_kwh = 0;

/*echo '<pre>';
print_r($data);
echo '</pre>';*/

/*echo '<pre>';
print_r($data_new);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['monthly-stock-take']),
]); ?>

<div class="row" style="">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->dropDownList($period_dropdown_arr, [
            'prompt' => 'Choose period...',
            'onchange'=>'this.form.submit()'
        ]); ?>
    </div>
    <div class="form-group" style="display: none;">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Current Progress (Last Update : <?= date('Y-m-d H:i:s'); ?>)</h3>
    </div>
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                'modules/drilldown',
                //'themes/grid-light',
                'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'height' => 400,
                    'events' => [
                        'load' => new JsExpression("
                            function(){
                                this.series[0].data[0].doDrilldown();
                            }
                        "),
                    ],
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => null,
                ],
                'xAxis' => [
                    'categories' => $categories,
                    /*'labels' => [
                        'enabled' => false,
                    ],*/
                ],
                'yAxis' => [
                    'min' => 0,
                    'max' => 100,
                ],
                'plotOptions' => [
                    'series' => [
                        'stacking' => 'percent',
                        'events' => [
                            'legendItemClick' => new JsExpression("
                                function(e){
                                    return false;
                                }
                            "),
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
                        ],
                        'dataLabels' => [
                            'enabled' => true
                        ],
                    ],
                ],
                'series' => $data_new,
                /*'drilldown' => [
                    'series' => $drilldown,
                    'allowPointDrilldown' => false
                ],*/
            ],
        ]);
        ?>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Daily Progress <i>(Total Slip : <?= number_format($total_all_slip); ?>)</i></h3>
    </div>
    <div class="panel-body">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                'modules/drilldown',
                //'themes/grid-light',
                'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'line',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'height' => 400,
                ],
                'credits' => [
                    'enabled' => false
                ],
                'title' => [
                    'text' => null,
                ],
                'xAxis' => [
                    'type' => 'datetime',
                    /*'labels' => [
                        'enabled' => false,
                    ],*/
                ],
                'tooltip' => [
                    'valueSuffix' => '%',
                    'shared' => true,
                ],
                'yAxis' => [
                    'min' => 0,
                    'max' => 100,
                    'title' => [
                        'text' => 'Percentage (%)'
                    ],
                ],
                'plotOptions' => [
                    'series' => [
                        'dataLabels' => [
                            'enabled' => true,
                        ],
                    ]
                ],
                'series' => $data2,
            ],
        ]);
        ?>
        <br/>
        <div class="row">
            <div class="col-sm-3">
                <div class="panel panel-primary" style="margin-bottom: 0px;">
                    <div class="panel-body text-center">
                        Total Count 1 : <b><?= number_format($tmp_total_slip1); ?></b> slip
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-primary" style="margin-bottom: 0px;">
                    <div class="panel-body text-center">
                        Total Count 2 : <b><?= number_format($tmp_total_slip2); ?></b> slip
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-primary" style="margin-bottom: 0px;">
                    <div class="panel-body text-center">
                        Total Audit 1 : <b><?= number_format($tmp_total_slip3); ?></b> slip
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-primary" style="margin-bottom: 0px;">
                    <div class="panel-body text-center">
                        Total Audit 2 : <b><?= number_format($tmp_total_slip4); ?></b> slip
                    </div>
                </div>
            </div>
        </div>
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