<?php
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => null,
    'tab_title' => 'Machine Daily Status',
    'breadcrumbs_title' => 'Machine Daily Status'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';
HighchartsAsset::register($this)->withScripts(['highstock']);

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
    .form-control, .control-label {background-color: #33383D; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #33383D;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #33383D;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}

    #progress-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
    }
    #progress-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #595F66;
        color: white;
        font-size: 24px;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    #progress-tbl > tbody > tr > td{
        border:1px solid #777474;
        font-size: 20px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
    }
");

date_default_timezone_set('Asia/Jakarta');

$script = "
    function refreshPage() {
       window.location = location.href;
    }
    window.onload = setupRefresh;
    var chart;



    function setupRefresh() {
      setTimeout(\"refreshPage();\", 60000); // milliseconds
    }
    

    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['current-status']) . "',
            success: function(data){
                //alert(data[0].mesin_id);
                var content = '';
                $.each(data , function(index, val) {
                    var background_color = '" . Yii::$app->params['bg-gray'] . "';
                    var color = 'black';
                    var status_txt = 'IDLE';
                    if(val.status_warna == 'KUNING'){
                        //background_color = 'yellow';
                        color = 'white';
                        background_color = '" . Yii::$app->params['bg-yellow'] . "';
                        status_txt = 'HADNLING';
                    } else if (val.status_warna == 'HIJAU') {
                        background_color = '" . Yii::$app->params['bg-green'] . "';
                        status_txt = 'RUNNING';
                        color = 'white';
                    } else if (val.status_warna == 'BIRU') {
                        background_color = '" . Yii::$app->params['bg-blue'] . "';
                        status_txt = 'SETTING';
                        color = 'white';
                    } else if (val.status_warna == 'MERAH') {
                        background_color = '" . Yii::$app->params['bg-red'] . "';
                        status_txt = 'STOP';
                        color = 'white';
                    }

                    $('#'+val.mesin_id).html('<button style=\"background-color: ' + background_color + '; color: ' + color + '; font-size: 12px;\" type=\"button\" class=\"btn btn-block btn-default\">' + status_txt + '</button>');

                    $.ajax({
                        type: 'POST',
                        url: '" . Url::to(['iot-timeline']) . "',
                        //url: 'http://localhost/yemi-app/web/display/get-machine-status?mesin_id=' + val.mesin_id + '&posting_date=" . date('Y-m-d') . "',
                        success: function(data2){
                            //$('#progress-MNT00078').html(data.title + ' : ' + data.message);
                            chart = new Highcharts.Chart({
                                chart : {
                                    type : 'column',
                                    renderTo: 'container-' + val.mesin_id,
                                    height : 20,
                                    backgroundColor : null,
                                    borderWidth : 0,
                                    margin : [2, 0, 2, 0],
                                    style : {
                                        overflow : 'visible'
                                    },
                                    skipClone : true,
                                },
                                credits : {
                                    enabled :false
                                },
                                title : {
                                    text : null
                                },
                                xAxis : {
                                    type : 'datetime',
                                    labels : {
                                        enabled : false
                                    },
                                    title : {
                                        text : null
                                    },
                                    startOnTick : false,
                                    endOnTick : false,
                                    tickPositions : [],
                                    //'type' : 'datetime',
                                    //'offset' : 10,
                                },
                                yAxis : {
                                    labels : {
                                        enabled : false
                                    },
                                    title : {
                                        text : null
                                    },
                                    startOnTick : false,
                                    endOnTick : false,
                                    tickPositions : [0],
                                },
                                legend : {
                                    enabled : false
                                },
                                tooltip : {
                                    //shared : true,
                                    crosshairs : true,
                                    xDateFormat : '%Y-%m-%d',
                                },
                                plotOptions : {
                                    column : {
                                        dataLabels : {
                                            enabled : false,
                                        },
                                        //'borderWidth' : 1,
                                        //'borderColor' : '',
                                    },
                                },
                                series : data2
                            });
                        }
                    });

                    
                });
            },
            complete: function(){
                setTimeout(function(){update_data();}, 100000);
            }
        });
    }

    function update_timeline(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['iot-timeline']) . "',
            success: function(data){
                $('#progress-MNT00078').html(data.title + ' : ' + data.message);
            }
        });
    }

    $(document).ready(function() {
        update_data();
        //update_timeline();
    });
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<table class="table" id="progress-tbl">
    <thead>
        <tr>
            <th style="width: 30%;">Machine</th>
            <th style="width: 10%;">Current</th>
            <th style="width: 30%;">Operational Status</th>
            <th style="width: 30%;">Summary</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($machine_arr as $key => $value) {
            ?>
            <tr>
                <td><?= $value; ?></td>
                <td class="machine" id="<?= $key; ?>"></td>
                <td id="<?= 'progress-' . $key; ?>">
                    <div id="container-<?= $key; ?>"></div>
                    
                </td>
                <td>
                    <span class="label bg-green" style="font-weight: normal; font-size: 14px;">RUNNING : X%</span>
                    <span class="label bg-blue" style="font-weight: normal; font-size: 14px;">SETTING : X%</span>
                    <span class="label bg-yellow" style="font-weight: normal; font-size: 14px;">HANDLING : X%</span>
                    <span class="label bg-red" style="font-weight: normal; font-size: 14px;">STOP : X%</span>
                    <span class="label bg-gray" style="font-weight: normal; font-size: 14px;">IDLING : X%</span>
                </td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>