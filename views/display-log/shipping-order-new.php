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
    'page_title' => 'Shipping Booking Management List <span class="japanesse light-green"></span>',
    'tab_title' => 'Shipping Booking Management List',
    'breadcrumbs_title' => 'Shipping Booking Management List'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    //.form-control, .control-label {background-color: #FFF; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #ecf0f5;}
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
        font-size: 14px;
        background: white;
        color: black;
        vertical-align: middle;
        //padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #777474 !important;
        background-color: rgba(255, 229, 153, 0.5);
        color: black;
        font-size: 16px;
        //border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
     .tbl-header{
        border:1px solid #8b8c8d !important;
        background-color: #518469 !important;
        color: black !important;
        font-size: 16px !important;
        border-bottom: 7px solid #797979 !important;
        vertical-align: middle !important;
    }
    .summary-tbl > tfoot > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        background: #000;
        color: white;
        vertical-align: middle;
        padding: 20px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }

    #my-title {
        font-size: 28px;
        font-weight: bold;
        background-color: #a6ff79;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .bg-red-mod {
        background-color: #ff5945 !important;
    }

    .total-container {
        font-size: 24px;
        font-weight: bold;
    }

    .total-pct {
        font-size: 18px;
        font-style: italic;
    }

    .info-box-text {
        font-size: 18px;
        letter-spacing: 1.5px;
    }

    .info-box-number {
        font-size: 30px;
        padding-top: 5px;
        letter-spacing: 1.5px;
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
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";

$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($tmp_shipping_order);
echo '</pre>';*/

?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['shipping-order-new']),
]); ?>

<div class="row" style="padding-top: 10px;">
    <div class="col-sm-3">
        <div class="row" style="">
            <div class="col-sm-6" style="">
                <?= $form->field($model, 'period', [
                    'template' => '
                    <div class="input-group col-sm-12">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                        {input}
                    </div>
                    {error}{hint}
                    '])->textInput(['style' => 'height: 35px;', 'placeholder' => 'Choose period...'])->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">PLAN (PCS)</span>
                        <span class="info-box-number"><?= number_format($total_plan); ?></span>
                    </div>
                <!-- /.info-box-content -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-check-square-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">CONFIRMED (PCS)</span>
                        <span class="info-box-number"><?= number_format($total_confirm); ?> <span style="font-size: 0.6em;">(<?= $pct_arr['confirm']; ?>%)</span></span>
                    </div>
                <!-- /.info-box-content -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="info-box">
                    <span class="info-box-icon"><i class="fa fa-truck"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">ETD YEMI (PCS)</span>
                        <span class="info-box-number"><?= number_format($total_etd_yemi); ?> <span style="font-size: 0.6em;">(<?= $pct_arr['etd_yemi']; ?>%)</span></span>
                    </div>
                <!-- /.info-box-content -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="info-box">
                    <span class="info-box-icon bg-orange"><i class="fa fa-ship"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">ETD PORT (PCS)</span>
                        <span class="info-box-number"><?= number_format($total_on_board); ?> <span style="font-size: 0.6em;">(<?= $pct_arr['etd_port']; ?>%)</span></span>
                    </div>
                <!-- /.info-box-content -->
                </div>
            </div>
        </div>

        <div class="row" style="display: none;">
            <div class="col-sm-12">
                <div class="info-box">
                    <span class="info-box-icon bg-navy"><i class="fa fa-warning"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">REJECTED</span>
                        <span class="info-box-number"><?= number_format($total_reject); ?> <span style="font-size: 0.6em;">(<?= $pct_arr['reject']; ?>%)</span></span>
                    </div>
                <!-- /.info-box-content -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-close"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">NOT CONFIRMED (PCS)</span>
                        <span class="info-box-number"><?= number_format($total_unconfirm); ?> <span style="font-size: 0.6em;">(<?= $pct_arr['unconfirm']; ?>%)</span></span>
                    </div>
                <!-- /.info-box-content -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="info-box">
                    <span class="info-box-icon bg-black"><i class="fa fa-minus"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">NO NEED ANYMORE (PCS)</span>
                        <span class="info-box-number"><?= number_format($total_no_need); ?> <span style="font-size: 0.6em;">(<?= $pct_arr['no_need']; ?>%)</span></span>
                    </div>
                <!-- /.info-box-content -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= Html::a('<i class="fa fa-fw fa-list"></i> Booking List', ['ship-reservation-data/index', 'PERIOD' => $model->period], [
                    'class' => 'btn btn-primary btn-block btn-lg',
                    'target' => '_blank',
                ]); ?>
            </div>
        </div>
        <br/>
    </div>
    <div class="col-sm-9">
        <b>Last Update : <?= $last_update; ?></b>
        <div class="panel panel-primary">
            <div class="panel-body no-padding">
                <?php
                echo Highcharts::widget([
                    'scripts' => [
                        //'modules/exporting',
                        //'themes/sand-signika',
                        //'themes/grid-light',
                        //'themes/dark-unica',
                    ],
                    'options' => [
                        'chart' => [
                            'type' => 'column',
                            'style' => [
                                'fontFamily' => 'sans-serif',
                            ],
                            'zoomType' => 'x',
                            'height' => 700
                        ],
                        'title' => [
                            'text' => 'Shipping Booking Management List'
                        ],
                        'subtitle' => [
                            'text' => $period_name
                        ],
                        'xAxis' => [
                            'type' => 'datetime',
                            'tickInterval' => 3600 * 1000 * 24,
                            //'categories' => $value['category'],
                        ],
                        'yAxis' => [
                            'title' => [
                                'text' => 'Total Container'
                            ],
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'plotOptions' => [
                            'column' => [
                                'stacking' => 'normal',
                                'dataLabels' => [
                                    'enabled' =>true
                                ],
                            ],
                            'series' => [
                                'pointPadding' => 0.1,
                                'groupPadding' => 0,
                            ],
                        ],
                        'series' => $data
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="row">
    <div class="col-sm-12">
        <table class="table summary-tbl">
            <thead>
                <tr>
                    <th class="text-center">DESTINATION</th>
                    <th class="text-center" width="18%">PLAN (PCS)</th>
                    <th class="text-center" width="18%">CONFIRMED (PCS)</th>
                    <th class="text-center" width="18%">REJECTED (PCS)</th>
                    <th class="text-center" width="18%">NOT CONFIRMED (PCS)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_by_pod as $value): ?>
                    <tr>
                        <td class="text-center"><?= $value->POD; ?></td>
                        <td class="text-center"><?= number_format($value->TOTAL_CONFIRMED + $value->TOTAL_UNCONFIRMED); ?></td>
                        <td class="text-center"><?= number_format($value->TOTAL_CONFIRMED); ?></td>
                        <td class="text-center"><?= number_format(0); ?></td>
                        <td class="text-center<?= $value->TOTAL_UNCONFIRMED > 0 ? ' bg-red-mod' : ''; ?>"><?= number_format($value->TOTAL_UNCONFIRMED); ?></td>
                    </tr>
                    
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>