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
    'page_title' => 'PRINTER USAGE (OPEN) <span class="japanesse light-green"></span>',
    'tab_title' => 'PRINTER USAGE (OPEN)',
    'breadcrumbs_title' => 'PRINTER USAGE (OPEN)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.4em; text-align: center;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 14px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        //font-size: 14px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 100px;
    }
    tbody > tr > td { background: #33383d;}
    tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}
");

$no = 0;
$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 10000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
if ($is_admin != 1) {
    $this->registerJs($script, View::POS_HEAD );
}


/*echo '<pre>';
print_r($data_nolog);
echo '</pre>';*/

?>
<span style="color: white;">Last Update : <?= date('Y-m-d H:i:s'); ?></span>
<table class="table table-responsive">
    <thead>
        <tr>
            <th class="text-center" style="<?= $is_admin == 1 ? '' : 'display: none;'; ?>">Act.</th>
            <th class="text-center">No.</th>
            <th class="text-center" width="120px">Machine IP</th>
            <th class="text-center" width="100px">Job Type</th>
            <th class="text-center" width="140px">Username</th>
            <th class="text-center" width="160px">Completed Time</th>
            <th>Job Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tmp_list as $value): 
            $no++;
            ?>
            <tr>
                <td class="text-center" width="50px" style="<?= $is_admin == 1 ? '' : 'display: none;'; ?>"><?= Html::a('<i class="glyphicon glyphicon-check"></i>', ['printer-usage-close', 'seq' => $value->seq], [
                    'title' => 'Close Job',
                    'data-confirm' => 'Are you sure to close this job ?'
                    ]); ?></td>
                <td class="text-center" width="50px"><?= $no; ?></td>
                <td class="text-center"><?= $value->machine_ip; ?></td>
                <td class="text-center"><?= $value->job_type; ?></td>
                <td class="text-center"><?= $value->user_name; ?></td>
                <td class="text-center"><?= date('Y-m-d H:i:s', strtotime($value->completed_time)); ?></td>
                <td><?= $value->job_name; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>