<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'Critical Control Room <span class="japanesse light-green">音湿度の管理</span>',
    'tab_title' => 'Critical Control Room',
    'breadcrumbs_title' => 'Critical Control Room'
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

    .table{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    .table > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #797979;
        vertical-align: middle;
    }
    .table > tbody > tr > td{
        border:1px solid #777474;
        font-size: 1.9em;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
        min-height: 80px;
    }
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 3.8em !important;}
    .description {font-size: 2.2em; padding-left: 10px;}
    .text-red{color: #ff1c00 !important;}
");

//$this->registerCssFile('@web/css/responsive.css');

date_default_timezone_set('Asia/Jakarta');

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 3600000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }

    $(document).ready(function() {
        var i = 0;
        setInterval(function() {
            i++;
            if(i%2 == 0){
                $(".blinked").css("color", "white");
                //$(".blinked").css("color", "white");
            } else {
                $(".blinked").css("color", "red");
                //$(".blinked").css("color", "#555");
            }
        }, 300);
    });

JS;
$this->registerJs($script, View::POS_HEAD );

$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['critical-temp-update']) . "',
            success: function(data){
                $.each(data.temp_data_arr , function(index, val) {
                    //alert(index);
                    $('#temp-'+index).html(val);
                });
                $.each(data.humi_data_arr , function(index, val) {
                    //alert(index);
                    $('#humi-'+index).html(val);
                });
                $.each(data.standard_temp_arr , function(index, val) {
                    //alert(index);
                    $('#standard-temp-'+index).html(val);
                });
                $.each(data.standard_humi_arr , function(index, val) {
                    //alert(index);
                    $('#standard-humi-'+index).html(val);
                });
            },
            complete: function(){
                setTimeout(function(){update_data();}, 5000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
    });
");

$this->registerJs($script, View::POS_END);

?>

<table id="smt-today" class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th>Area</th>
            <th class="text-center">Standard 基準<br/>Temperature (&deg;C)</th>
            <th class="text-center">Actual 現在<br/>Temperature (&deg;C)</th>
            <th class="text-center">Standard 基準<br/>Humidity (%)</th>
            <th class="text-center">Actual 現在<br/>Humidity (%)</th>
        </tr>
    </thead>
    <tbody id="body-content">
        <?php foreach ($title_arr as $key => $value): ?>
            <?php
            $temp_min = $temp_max = $humi_min = $humi_max = 0;
            foreach ($data as $key2 => $value2) {
                if ((int)$key == $value2->map_no) {
                    $temp_min = $value2->temp_min;
                    $temp_max = $value2->temp_max;
                    $humi_min = $value2->humi_min;
                    $humi_max = $value2->humi_max;
                    $act_temp = $value2->temparature;
                    $act_humi = $value2->humidity;
                }
            }
            $temp_txt_class = 'text-green';
            if ($value->map_no == 17 || $value->map_no == 18) {
                if ($act_temp < $temp_min) {
                    $temp_txt_class = 'text-red blinked';
                }
            } else {
                if ($act_temp > $temp_max) {
                    $temp_txt_class = 'text-red blinked';
                }
            }
            
            $humi_txt_class = 'text-green';
            if ($act_humi < $humi_min || $act_humi > $humi_max) {
                $humi_txt_class = 'text-red blinked';
            }
            ?>
            <tr>
                <td><?= $value ?></td>
                <td id="standard-temp-<?= $key; ?>" class="text-center target"><?= $temp_min . ' - ' . $temp_max; ?></td>
                <td id="temp-<?= $key; ?>" class="text-center actual"><span class="<?= $temp_txt_class; ?>"><?= $act_temp; ?></span></td>
                <td id="standard-humi-<?= $key; ?>" class="text-center target"><?= $humi_min . ' - ' . $humi_max; ?></td>
                <td id="humi-<?= $key; ?>" class="text-center actual"><span class="<?= $humi_txt_class; ?>"><?= $act_humi; ?></span></td>
            </tr>
        <?php endforeach ?>
        
    </tbody>
</table>