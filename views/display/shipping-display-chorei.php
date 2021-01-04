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
    'page_title' => 'PRODUCTION FOR WEEKLY SHIPPING <span class="japanesse light-green"></span>',
    'tab_title' => 'PRODUCTION FOR WEEKLY SHIPPING',
    'breadcrumbs_title' => 'PRODUCTION FOR WEEKLY SHIPPING'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.8em; text-align: center; letter-spacing: 1.5px;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5; font-family: 'Open Sans', sans-serif;}
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
        margin-bottom: 0px;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 50px;
        background: #2f2f2f;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border: 2px solid #595F66;
        border-top: 0px;
        background-color: #518469;
        color: #ffeb3b;
        font-size: 30px;
        //border-bottom: 2px solid #797979;
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
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #2f2f2f;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .current-week {
        background-color: #121213 !important;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    .panel-title {
        font-size: 70px;
    }
    .panel-body {
        background-color: black;
        color: white;
    }
    .progress-row{
        font-size: 50px;
        padding-left: 10px;
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
print_r($tmp_new_data);
echo '</pre>';*/
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['shipping-display-chorei']),
]); ?>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-2">
        <?= $form->field($model, 'period')->textInput(
            [
                'onchange'=>'this.form.submit()'
            ]
        ); ?>
    </div>
    
    
</div>

<?php ActiveForm::end(); ?>

<table class="table summary-tbl">
    <thead>
        <tr>
            <th rowspan="2">BU</th>
            <?php foreach ($tmp_week_arr as $key => $value): ?>
                <th class="text-center" colspan="3" style="line-height: 80%;" width="200px"><?= 'WEEK ' . $key; ?><br/><span style="font-size: 0.5em;">(<?= date('d M\' y', strtotime($value['start_date'] . ' +1 day')); ?> - <?= date('d M\' y', strtotime($value['end_date'] . ' +1 day')); ?>)</span></th>
            <?php endforeach ?>
        </tr>
        <tr>
            <?php foreach ($tmp_week_arr as $key => $value): ?>
                <th class="text-center" style="font-size: 24px;" width="110px;">P<span style="font-size: 0.6em;">LAN</span></th>
                <th class="text-center" style="font-size: 24px;" width="110px;">A<span style="font-size: 0.6em;">CTUAL</span></th>
                <th class="text-center" style="font-size: 24px;" width="110px;">P<span style="font-size: 0.6em;">ROGRESS</span></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tmp_new_data as $bu_val => $bu_data): ?>
            <tr>
                <td><?= $bu_val; ?></td>
                <?php foreach ($bu_data as $week_no => $value): ?>
                    <td class="text-center<?= $current_week == $week_no ? ' current-week' : ''; ?>" style="font-size: 1.9em;"><?= number_format($value['plan']); ?></td>
                    <td class="text-center<?= $current_week == $week_no ? ' current-week' : ''; ?>" style="font-size: 1.9em;"><?= number_format($value['actual']); ?></td>
                    <td class="text-center<?= $value['progress_class']; ?><?= $current_week == $week_no ? ' current-week' : ''; ?>" style="font-size: 1.9em; font-weight: bold"><?= ($value['progress']); ?><span style="font-size: 0.6em;">%</span></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="row" style="padding-top: 20px; display: none;">
    <?php foreach ($data as $week_no => $data_val_arr): ?>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">WEEK <?= $week_no; ?> (<?= $data_summary[$week_no]['progress']; ?><span style="font-size: 0.8em;">%</span>)</h3>
                </div>
                <div class="panel-body no-padding">
                    
                    <table class="table summary-tbl">
                        <thead>
                            <tr>
                                <th>BU</th>
                                <th class="text-center">PLAN (SET)</th>
                                <th class="text-center">ACTUAL (SET)</th>
                                <th class="text-center">PROGRESS (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_val_arr as $bu_val => $value): ?>
                                <tr>
                                    <td><?= $bu_val; ?></td>
                                    <td class="text-center"><?= number_format($value['plan']); ?></td>
                                    <td class="text-center"><?= number_format($value['actual']); ?></td>
                                    <td class="text-center<?= $value['progress'] < 100 && $value['plan'] > 0 ? ' text-red' : ''; ?>"><?= $value['progress']; ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<?php
if (count($top_minus) == 0) { } else {
    ?>
    <div class="row" style="padding: 10px;">
        <?php foreach ($top_minus as $value): ?>
            <div class="text-center col-md-4" style="font-size: 2em; color: white;">
                <?= $value->gmc; ?> | <?= $value->gmc_desc . ' ' . $value->gmc_destination; ?> | <span class="text-red"><?= $value->balance; ?></span>
            </div>
        <?php endforeach ?>
    </div>
<?php }
?>
<br/>
<span style="color: silver; font-size: 20px;"><i>Last Update : <?= date('Y-m-d H:i:s'); ?></i></span>