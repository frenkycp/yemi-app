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
    'page_title' => 'Stock Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Stock Monitoring',
    'breadcrumbs_title' => 'Stock Monitoring'
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

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
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
    .summary-tbl > tfoot > tr > td{
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
    .summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .bg-yellow-mod {background-color: yellow !important;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}
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
$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
        e.preventDefault();
        $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
   });
});");

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['stock-monitoring']),
]); ?>

<div style="margin-top: 10px;">
    <div class="row">
        <div class="col-sm-10">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'from_date')->widget(DatePicker::classname(), [
                        'options' => [
                            'type' => DatePicker::TYPE_INPUT,
                        ],
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'todayBtn' => true,
                        ]
                    ]); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'to_date')->textInput([
                        'readonly' => true,
                        'style' => 'background-color: black;'
                    ])->label('To Date (Today)') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'item')->widget(Select2::classname(), [
                        'data' => $item_arr,
                        'options' => [
                            'placeholder' => 'Choose Item...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="form-group">
                    <br/>
                    <?= Html::submitButton('GENERATE CHART', ['class' => 'btn btn-default', 'style' => 'margin-top: 5px;']); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2" style="font-size: 34px;">
            <div class="panel panel-default" style="margin-bottom: 0px;">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">AVG Percentage (%)</h3>
                </div>
                <div class="panel-body no-padding text-center">
                    <?= $pct; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $item_desc; ?></h3>
    </div>
    <div class="panel-body no-padding">
        <?=
        Highcharts::widget([
            'scripts' => [
                'highcharts-more',
                //'modules/exporting',
                //'themes/sand-signika',
                'modules/solid-gauge',
                //'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'line',
                    'height' => '500',
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'zoomType' => 'x'
                ],
                'title' => [
                    'text' => null,
                ],
                'xAxis' => [
                    'type' => 'datetime',
                    'lineWidth' => 1,
                ],
                'yAxis' => [
                    'minorGridLineWidth' => 0,
                    'title' => [
                        'text' => $um,
                    ],
                    'allowDecimals' => false,
                    /*'stackLabels' => [
                        'enabled' => true,
                    ],*/
                    //'min' => 0,
                    //'tickInterval' => 20
                ],
                'legend' => [
                    'enabled' => true,
                ],
                'credits' => [
                    'enabled' => false
                ],
                'tooltip' => [
                    'enabled' => true,
                    'valueSuffix' => ' ' . $um,
                    'shared' => true,
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'line' => [
                        //'stacking' => 'normal',
                        'marker' => [
                            'enabled' => false
                        ],
                        'dataLabels' => [
                            'enabled' => true,
                        ],
                    ],
                    
                ],
                'series' => $data,
            ],
        ]);
        ?>
    </div>
    <div class="panel-footer" style="font-size: 20px;">
        <span><u>Actual Stock Detail by Location :</u></span>
        <ul>
            <?php foreach ($actual_stock_by_loc as $key => $value): ?>
                <li><?= $key; ?> : <b><?= $value; ?></b> <?= $um; ?></li>
            <?php endforeach ?>
        </ul>
        
    </div>
</div>