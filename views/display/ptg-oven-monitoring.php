<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Oven Monitoring (Painting) <span class="japanesse light-green"></span>',
    'tab_title' => 'Oven Monitoring (Painting) ',
    'breadcrumbs_title' => 'Oven Monitoring (Painting) ',
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
    <?php foreach ($data as $key => $value): ?>
        <div class="col-md-6">
            <div class="box box-default box-solid">
                <div class="box-header" style="vertical-align: middle;">
                    <h3 class="box-title"><?= $value['description'] ?></h3>
                    <div class="pull-right" style="color: white;">
                        <?php 
                        $temperature = 0;
                        $temp_min = $temp_max = 0;
                        if ($key == 'MNTOVN01') {
                            $temperature = $oven_room_1->temparature;
                            $temp_min = $oven_room_1->temp_min;
                            $temp_max = $oven_room_1->temp_max;
                        }
                        if ($key == 'MNTOVN02') {
                            $temperature = $oven_room_2->temparature;
                            $temp_min = $oven_room_2->temp_min;
                            $temp_max = $oven_room_2->temp_max;
                        }
                        ?>
                        
                        <div class="bg-light-blue text-center" style="padding: 3px 10px; border-radius: 5px; letter-spacing: 2px;">
                            <span style="font-size: 16px;">Temperature : <?= $temperature; ?>&deg;</span><br/>
                            <span style="color: silver;">(Normal : <?= $temp_min; ?>&deg; - <?= $temp_max; ?>&deg;)</span>
                        </div>
                    </div>
                </div>
                <div class="box-body" style="background-color: black;">
                    
                    <?php
                    if (!isset($value['data'])) {

                        ?>
                        <tr>
                            <td colspan="6"></td>
                        </tr>
                    <?php } else {

                        ?>
                        <div class="row">
                            <?php foreach ($value['data'] as $key2 => $value2): ?>
                            <?php
                                $datetime1 = new \DateTime(date('Y-m-d H:i:s', strtotime($value2->start_date)));
                                $datetime2 = new \DateTime(date('Y-m-d H:i:s'));
                                $interval = $datetime1->diff($datetime2);
                                $minutes = $interval->days * 24 * 60;
                                $minutes += $interval->h * 60;
                                $minutes += $interval->i;

                                $bg_class = ' bg-green';
                                if ($minutes > $value2->oven_time) {
                                    $bg_class = ' bg-red';
                                }

                                //$target_oven_time = convertMinute();
                                ?>
                                <div class="col-md-4">
                                    <div class="text-center<?= $bg_class; ?>" style="border-radius: 5px;">
                                        <div style="border-bottom: 1px solid white; margin: 0px 10px; font-size: 16px; letter-spacing: 3px; font-weight: bold;"><?= $value2->model_group; ?> <small style="font-weight: normal; letter-spacing: 1px;">(<?= number_format($value2->act_qty); ?> PCS)</small></div>
                                        <div style="border-bottom: 1px solid white; margin: 0px 10px; font-size: 18px;">ID : <?= $value2->minor; ?></div>
                                        <div style="padding: 5px;"><span style="letter-spacing: 1px; font-size: 16px;"><?= number_format($minutes); ?></span> minutes <small>( TARGET > <?= number_format($value2->oven_time); ?> )</small></div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>