<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Production\'s Attendance (' . $location . ') on ' . date('d F \'Y', strtotime($post_date)) . '<span class="japanesse light-green"></span>',
    'tab_title' => 'Production\'s Attendance',
    'breadcrumbs_title' => 'Production\'s Attendance'
];
$color = 'ForestGreen';

$this->registerCss("
    .control-label {color: white;}
    //.form-control, .control-label {background-color: #000; color: white; border-color: white;}
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
    .clinic-container {border: 1px solid white; border-radius: 10px; padding: 5px 20px;}

    #table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    #table > tbody > tr > td{
        border:1px solid #777474;
        font-size: 2.5em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        //height: 100px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .description {font-size: 2.2em; padding-left: 10px;}
    .text-red{color: #ff1c00 !important; font-weight: bold;}
");

//$this->registerCssFile('@web/css/responsive.css');

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
$shift_arr = [1, 2, 3];

?>
<div class="row">
    <?php foreach ($shift_arr as $shift_val): ?>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">SHIFT <?= $shift_val; ?></h3>
                </div>
                <div class="panel-body no-padding">
                    <table class="table table-responsive table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">NIK</th>
                                <th>Name</th>
                                <th class="text-center">Plan</th>
                                <th class="text-center">Actual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (count($data[$shift_val]) > 0) {
                                foreach ($data[$shift_val] as $key => $value) {
                                    if ($value['plan'] == 1) {
                                        $plan_val = '<i class="fa fa-check text-green"></i>';
                                    } else {
                                        $plan_val = '<i class="fa fa-close text-red"></i>';
                                    }

                                    if ($value['actual'] == 1) {
                                        $actual_val = '<i class="fa fa-check text-green"></i>';
                                    } else {
                                        $actual_val = '<i class="fa fa-close text-red"></i>';
                                    }
                                    echo '<tr>
                                        <td class="text-center">' . $no . '</td>
                                        <td class="text-center">' . $key . '</td>
                                        <td>' . $value['name'] . '</td>
                                        <td class="text-center">' . $plan_val . '</td>
                                        <td class="text-center">' . $actual_val . '</td>
                                    </tr>';
                                    $no++;
                                }
                            } else {
                                echo '<tr>
                                    <td colspan="4">No Data</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>