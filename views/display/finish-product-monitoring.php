<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Finish Product Monitoring (SPU) <span class="japanesse light-green"></span>',
    'tab_title' => 'Finish Product Monitoring (SPU) ',
    'breadcrumbs_title' => 'Finish Product Monitoring (SPU) ',
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

function convertMinute($minutes)
{
    $data = [
        'unit' => 'minute',
        'value' => 0
    ];
    if ($minutes >= 2) {
        $data['unit'] = 'minutes';
    }

    if ($minutes >= 60 && $minutes < (24 * 60)) {
        $data = [
            'unit' => 'hour',
            'value' => round(($minutes / 60))
        ];
        if (($minutes / 60) >= 2) {
            $data['unit'] = 'hours';
        }
    }

    if ($minutes >= (24 * 60)) {
        $data = [
            'unit' => 'day',
            'value' => round(($minutes / (24 * 60)))
        ];
        if (($minutes / (24 * 60)) >= 2) {
            $data['unit'] = 'days';
        }
    }

    return $data;
}

$this->registerCss("
    .control-label {color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .container {width: auto;}
    //.content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    .tab-content > .tab-pane,
    .pill-content > .pill-pane {
        display: block;     
        height: 0;          
        overflow-y: hidden; 
    }

    .tab-content > .active,
    .pill-content > .active {
        height: auto;
    }
    th {
        vertical-align: middle !important;
    }
    .box-body {
        min-height: 450px;
    }
");

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 30000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Finish Product (Seasoning)</h3>
            </div>
            <div class="box-body" style="background-color: black;">
                <div class="row">
                    <?php
                    if (count($data) > 0) {
                        ?>
                        <?php foreach ($data as $key => $value): ?>
                            <?php

                            $datetime1 = new \DateTime(date('Y-m-d H:i:s', strtotime($value->start_date)));
                            $datetime2 = new \DateTime(date('Y-m-d H:i:s'));
                            $interval = $datetime1->diff($datetime2);
                            $minutes = $interval->days * 24 * 60;
                            $minutes += $interval->h * 60;
                            $minutes += $interval->i;

                            $bg_class = ' bg-green';
                            if ($minutes > $value->oven_time) {
                                $bg_class = ' bg-red';
                            }

                            //$target_oven_time = convertMinute();
                            ?>
                            <div class="col-md-4">
                                <div class="text-center<?= $bg_class; ?>" style="border-radius: 5px;">
                                    <div style="border-bottom: 1px solid white; margin: 0px 10px; font-size: 16px; letter-spacing: 3px; font-weight: bold;"><?= $value->model_group; ?> <small style="font-weight: normal; letter-spacing: 1px;">(<?= number_format($value->act_qty); ?> PCS)</small></div>
                                    <div style="border-bottom: 1px solid white; margin: 0px 10px; font-size: 18px;">ID : <?= $value->minor; ?></div>
                                    <div style="padding: 5px;"><span style="letter-spacing: 1px; font-size: 16px;"><?= number_format($minutes); ?></span> minutes <small>( TARGET > <?= number_format($value->oven_time); ?> )</small></div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Finish Product (Waiting Final Assy)</h3>
            </div>
            <div class="box-body" style="background-color: black;">
                <div class="row">
                    <?php
                    if (count($data2) > 0) {
                        ?>
                        <?php foreach ($data2 as $key => $value): ?>
                            <?php

                            $datetime1 = new \DateTime(date('Y-m-d H:i:s', strtotime($value->start_date)));
                            $datetime2 = new \DateTime(date('Y-m-d H:i:s'));
                            $interval = $datetime1->diff($datetime2);
                            $minutes = $interval->days * 24 * 60;
                            $minutes += $interval->h * 60;
                            $minutes += $interval->i;

                            $bg_class = ' bg-green';
                            if ($minutes > $value->oven_time) {
                                $bg_class = ' bg-red';
                            }

                            //$target_oven_time = convertMinute();
                            ?>
                            <div class="col-md-4" style="margin-bottom: 10px;">
                                <div class="text-center<?= $bg_class; ?>" style="border-radius: 5px;">
                                    <div style="border-bottom: 1px solid white; margin: 0px 10px; font-size: 16px; letter-spacing: 3px; font-weight: bold;"><?= $value->model_group; ?> <small style="font-weight: normal; letter-spacing: 1px;">(<?= number_format($value->act_qty); ?> PCS)</small></div>
                                    <div style="border-bottom: 1px solid white; margin: 0px 10px; font-size: 18px;">ID : <?= $value->minor; ?></div>
                                    <div style="padding: 5px;"><span style="letter-spacing: 1px; font-size: 16px;"><?= number_format($minutes); ?></span> minutes <small>( TARGET < <?= number_format($value->oven_time); ?> )</small></div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>