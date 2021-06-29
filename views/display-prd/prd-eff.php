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
    'page_title' => 'TOTAL PRODUCTION EFFICIENCY <span class="japanesse light-green">(全体生産能率)</span>',
    'tab_title' => 'TOTAL PRODUCTION EFFICIENCY',
    'breadcrumbs_title' => 'TOTAL PRODUCTION EFFICIENCY'
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

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 18px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 2px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 20px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
        font-weight: normal;
        letter-spacing: 2px;
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
    .panel-body {
        background-color: black;
    }
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
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

/*echo '<pre>';
print_r($tmp_daily_eff_data);
echo '</pre>';*/

//echo Yii::$app->request->baseUrl;
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    'layout' => 'horizontal',
    'action' => Url::to(['prd-eff']),
]); ?>

<div class="row" style="margin-top: 5px;">
    <div class="col-sm-3">
        <?= $form->field($model, 'fiscal_year')->dropDownList(ArrayHelper::map(app\models\FiscalTbl::find()->select('FISCAL')->groupBy('FISCAL')->orderBy('FISCAL DESC')->all(), 'FISCAL', 'FISCAL'), [
                'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Monthly Efficiency</h3>
    </div>
    <div class="panel-body no-padding">
        <?php
        echo Highcharts::widget([
            'scripts' => [
                //'modules/exporting',
                'themes/dark-unica',
                //'themes/sand-signika',
            ],
            'options' => [
                'chart' => [
                    'type' => 'column',
                    'height' => 300,
                    'style' => [
                        'fontFamily' => 'sans-serif'
                    ],
                    'backgroundColor' => 'black',
                    'marginRight' => 30,
                ],
                'credits' => [
                    'enabled' =>false
                ],
                'title' => [
                    'text' => null
                ],
                'subtitle' => [
                    'text' => null
                ],
                'xAxis' => [
                    'categories' => $categories,
                    'labels' => [
                        'style' => [
                            'fontSize' => '22px'
                        ],
                    ],
                ],
                'yAxis' => [
                    'min' => 0,
                    'title' => [
                        'text' => null
                    ],
                    'max' => 120,
                ],
                'plotOptions' => [
                    'column' => [
                        'dataLabels' => [
                            'enabled' => true,
                            'format' => '{y}%',
                            'style' => [
                                'fontSize' => '32px'
                            ],
                        ]
                    ],
                    'series' => [
                        'pointPadding' => 0.1,
                        'groupPadding' => 0,
                        /*'cursor' => 'pointer',
                        'point' => [
                            'events' => [
                                'click' => new JsExpression('
                                    function(){
                                        $("#modal").modal("show").find(".modal-content").html(this.options.remark);
                                    }
                                '),
                            ]
                        ]*/
                    ],
                ],
                'series' => $data_chart
            ],
        ]);
        ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Daily Efficiency (<?= $period_str; ?>)</h3>
    </div>
    <div class="panel-body no-padding">
        <?=
        Highcharts::widget([
            'scripts' => [
                'highcharts-more',
                //'modules/exporting',
                //'themes/sand-signika',
                //'modules/solid-gauge',
                'themes/dark-unica',
            ],
            'options' => [
                'chart' => [
                    'type' => 'spline',
                    'height' => 300,
                    'style' => [
                        'fontFamily' => 'sans-serif',
                    ],
                    'zoomType' => 'x',
                    'backgroundColor' => 'black',
                    'marginRight' => 30,
                ],
                'title' => [
                    'text' => null,
                ],
                'xAxis' => [
                    'type' => 'datetime',
                ],
                'yAxis' => [
                    'minorGridLineWidth' => 0,
                    'title' => [
                        'text' => $um,
                    ],
                    'min' => 50,
                ],
                'legend' => [
                    'enabled' => true,
                ],
                'credits' => [
                    'enabled' => false
                ],
                'tooltip' => [
                    'enabled' => true,
                    //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                ],
                'plotOptions' => [
                    'spline' => [
                        //'stacking' => 'normal',
                        'dataLabels' => [
                            'enabled' => true,
                        ],
                    ],
                    
                ],
                'series' => $daily_chart,
            ],
        ]);
        ?>
    </div>
</div>

<table class="table summary-tbl" style="margin-bottom: 0px;">
    <thead>
        <tr>
            <th></th>
            <?php foreach ($categories as $value): ?>
                <th class="text-center"><?= $value; ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Prod. Time (hour)</td>
            <?php foreach ($data_table as $key => $value): ?>
                <td class="text-center"><?= number_format($value['st']); ?></td>
            <?php endforeach ?>
        </tr>
        <tr>
            <td>MP Time (hour)</td>
            <?php foreach ($data_table as $key => $value): ?>
                <td class="text-center"><?= number_format($value['wt']); ?></td>
            <?php endforeach ?>
        </tr>
    </tbody>
</table>
<span style="color: silver; font-size: 1.5em;">Last Update : <?= date('Y-m-d H:i'); ?></span>