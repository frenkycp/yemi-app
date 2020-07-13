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
    'page_title' => 'VMS vs FLO <span class="japanesse light-green"></span>',
    'tab_title' => 'VMS vs FLO',
    'breadcrumbs_title' => 'VMS vs FLO'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 3em; text-align: center;}
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
        font-size: 16px;
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
        background: #33383d;
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
    //#summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
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

$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

/*$script = "
    $('document').ready(function() {
        $('#popup-tbl').DataTable({
            'order': [[ 6, 'desc' ]]
        });
    });
";
$this->registerJs($script, View::POS_HEAD );*/

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
   $('.popup_btn').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load($(this).attr('href'));
     $('#popup-tbl').DataTable({
        'order': [[ 6, 'desc' ]]
    });
   });
});");
// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_data_arr);
echo '</pre>';*/
?>
<br/>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['vms-vs-flo']),
]); ?>

<div class="row" style="display: none;">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->dropDownList(
            $period_dropdown,
            [
                //'prompt' => 'Choose...',
            ]
        ); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'line')->dropDownList(
            $line_dropdown,
            [
                //'prompt' => 'Choose...',
            ]
        ); ?>
    </div>
    
    <div class="form-group">
        <br/>
        <?= Html::submitButton('GENERATE', ['class' => 'btn btn-primary', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<br/>
<div class="row">
    <div class="col-md-8">
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
                            'zoomType' => 'x',
                            'height' => 580
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
                                'text' => 'Total Qty'
                            ],
                            /*[
                                'title' => [
                                    'text' => 'VMS v.s FLO'
                                ],
                            ], [
                                'title' => [
                                    'text' => 'BALANCE'
                                ],
                                'opposite' => true,
                            ],*/
                        ],
                        'credits' => [
                            'enabled' =>false
                        ],
                        'tooltip' => [
                            'enabled' => true,
                            'shared' => true,
                            //'xDateFormat' => '%A, %b %e %Y',
                            'valueSuffix' => ' pcs'
                            //'formatter' => new JsExpression('function(){ return "Percentage : " + this.y + "%<br/>" + "Qty : " + Math.round(this.point.qty) + " item"; }'),
                        ],
                        'plotOptions' => [
                            'series' => [
                                'dataLabels' => [
                                    'enabled' => false
                                ],
                                'lineWidth' => 1.5,
                                'marker' => [
                                    'radius' => 2,
                                ],
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
    <div class="col-md-4">
        <table class="table table-bordered" style="font-size: 73px; margin-bottom: 0px;" id="yesterday-tbl">
            <tbody>
                <tr>
                    <td width="45%" style="background-color: #454B52;" class="label-tbl">Plan</td>
                    <td class="text-right"><?= number_format($yesterday_data['plan']); ?> <span style="font-size: 0.2em"> PCS</span></td>
                </tr>
                <tr>
                    <td style="background-color: #454B52;" class="label-tbl">Actual</td>
                    <td class="text-right"><?= number_format($yesterday_data['actual']); ?> <span style="font-size: 0.2em"> PCS</span></td>
                </tr>
                <tr>
                    <td style="background-color: #454B52;" class="label-tbl">Balance</td>
                    <td class="text-right">
                        <?php
                        $tmp_balance = '<span class="">' . number_format($yesterday_data['balance']) . '</span>';
                        if ($yesterday_data['balance'] < 0) {
                            $tmp_balance = '<span class="text-red">' . number_format($yesterday_data['balance']) . '</span>';
                        }
                        /*if ($yesterday_data['balance'] > 0) {
                            $tmp_balance = '<span class="text-green">' . number_format($yesterday_data['balance']) . '</span>';
                        }*/
                        echo $tmp_balance . '<span style="font-size: 0.2em"> PCS</span>';
                        ?>
                        <?= ''; //number_format($yesterday_data['balance']); ?>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #454B52;" class="label-tbl text-right"><span style="font-size: 0.7em; vertical-align: top;">↳ </span>KD</td>
                    <td class="text-right<?= $yesterday_data['kd_balance'] < 0 ? ' text-red' : ''; ?>"><?= number_format($yesterday_data['kd_balance']); ?> <span style="font-size: 0.2em; color: white;"> PCS</span></td>
                </tr>
                <tr>
                    <td style="background-color: #454B52;" class="label-tbl text-right"><span style="font-size: 0.7em; vertical-align: top;">↳ </span>FG</td>
                    <td class="text-right<?= $yesterday_data['kd_balance'] < 0 ? ' text-red' : ''; ?>"><?= number_format($yesterday_data['product_balance']); ?> <span style="font-size: 0.2em; color: white;"> PCS</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Detail Info</h3>',
        'size' => 'modal-lg',
    ]);
    yii\bootstrap\Modal::end();
?>