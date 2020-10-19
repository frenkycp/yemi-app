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
    'page_title' => 'Ship Reservation Summary <span class="japanesse light-green"></span>',
    'tab_title' => 'Ship Reservation Summary',
    'breadcrumbs_title' => 'Ship Reservation Summary'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    .form-group {margin-bottom: 0px;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .badge {font-weight: normal;}
    .panel {
        margin-bottom: 0px;
    }

    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
        margin-bottom: 0px;
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
        background-color: rgb(255, 229, 153);
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
//echo Yii::$app->request->baseUrl;
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['tol-monthly-summary']),
]); ?>
<br/>
<div class="row" style="">
    <div class="col-md-4">
        <?php echo '<label class="control-label">Select ETD range</label>';
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
        <?= Html::submitButton('GENERATE DATA', ['class' => 'btn btn-success', 'style' => 'margin-top: 5px;']); ?>
    </div>
    
</div>

<?php ActiveForm::end(); ?>
<br/>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Total Container by Ship Liner Category</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">MAIN</h3>
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped summary-tbl">
                            <thead>
                                <tr>
                                    <th class="text-center">40' HC</th>
                                    <th class="text-center">40'</th>
                                    <th class="text-center">20'</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= number_format($tmp_reservation_summary->main_40hc); ?></td>
                                    <td class="text-center"><?= number_format($tmp_reservation_summary->main_40); ?></td>
                                    <td class="text-center"><?= number_format($tmp_reservation_summary->main_20); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">SUB</h3>
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped summary-tbl">
                            <thead>
                                <tr>
                                    <th class="text-center">40' HC</th>
                                    <th class="text-center">40'</th>
                                    <th class="text-center">20'</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= number_format($tmp_reservation_summary->sub_40hc); ?></td>
                                    <td class="text-center"><?= number_format($tmp_reservation_summary->sub_40); ?></td>
                                    <td class="text-center"><?= number_format($tmp_reservation_summary->sub_20); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title">BACK UP</h3>
                    </div>
                    <div class="panel-body no-padding">
                        <table class="table table-striped summary-tbl">
                            <thead>
                                <tr>
                                    <th class="text-center">40' HC</th>
                                    <th class="text-center">40'</th>
                                    <th class="text-center">20'</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= number_format($tmp_reservation_summary->backup_40hc); ?></td>
                                    <td class="text-center"><?= number_format($tmp_reservation_summary->backup_40); ?></td>
                                    <td class="text-center"><?= number_format($tmp_reservation_summary->backup_20); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
