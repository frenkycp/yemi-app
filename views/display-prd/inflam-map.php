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
    'page_title' => 'Flamable/Hazard Item Monitoring',
    'tab_title' => 'Flamable/Hazard Item Monitoring',
    'breadcrumbs_title' => 'Flamable/Hazard Item Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');



$css_string = "
    //.form-control, .control-label {background-color: #FFF; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 0.7em; text-align: center; display: none;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    //.box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #FFF;}
    .content {padding-top: 0px;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
    #main-body {overflow: auto;}
    .client-widget {
        width: 20px;
        height: 20px;
        border: 1px solid black;
        border-radius: 10px;
    }
    .text-green {
        color: #07ff0e !important;
    }
    .text-red {
        color: #ff2222 !important;
    }
    .text-yellow {
        color: yellow !important;
    }
    .bg-green {
        background-color: #07ff0e !important;
    }
    .bg-red {
        background-color: #ff2222 !important;
    }
    .bg-yellow {
        background-color: yellow !important;
    }
    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
        margin-bottom: 0px;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid silver;
        font-size: 14px;
        background-color: rgba(50, 255, 75, 0.3);
        color: black;
        vertical-align: middle;
        padding: 0px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid silver !important;
        background-color: rgba(50, 255, 75, 1);
        color: black;
        font-size: 16px;
        padding: 0px;
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
    .attachment-img {
        padding: 2px;
    }
    .column-1 {width: 40%;}
    .column-2 {width: 30%;}
    .column-3 {width: 30%;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //#summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

$script = "
    function refreshPage() {
       window.location = location.href;
    }
    window.onload = setupRefresh;
    var chart;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }

    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['data-monitoring-data']) . "',
            success: function(data){
                $.each(data, function(index, val) {
                    $('#'+index).attr('class', val.new_class);
                    $('#'+index).attr('title', 'Line : '+index+' (Last Update : '+val.last_update+')');
                });
            },
            complete: function(){
                setTimeout(function(){update_data();}, 2000);
            }
        });
    }

    $(document).ready(function() {
        //update_data();
    });
";
$this->registerJs($script, View::POS_HEAD );

$this_time = date('Y-m-d H:i:s');

// echo $start_period . ' - ' . $end_period;
/*echo '<pre>';
print_r($tmp_data2);
echo '</pre>';*/
?>

<div id="main-body">
    <?= Html::img('@web/uploads/MAP/suhu_humidity_map.jpg', ['alt' => 'My logo', 'style' => 'opacity: 0.8', 'width' => '1850px']); ?>
    <?php foreach ($data_arr as $key => $value): 
        $top_pos = $value['location']['top'];
        $left_pos = $value['location']['left'];

        $icon_class = 'bg-green';

        $icon_class .= ' client-widget';
        ?>
        <div id="<?= $value->ID; ?>" title="<?= $value->LOC_DESC; ?>" class="<?= '';$icon_class; ?>" style="position: absolute; top: <?= $top_pos; ?>px; left: <?= $left_pos; ?>px; width: 180px; border-radius: 10px;">
            <div class="panel panel-default">
                <div class="panel-body no-padding">
                    <table class="table table-condensed summary-tbl" title="<?= $key; ?>">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="2" style="font-size: 12px;">
                                    <?= $key; ?>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center" width="50%">
                                    <?= Html::img('@web/uploads/ICON/flammable_02.png', ['class' => 'attachment-img', 'height' => '35px']); ?>
                                </th>
                                <th class="text-center">
                                    <?= Html::img('@web/uploads/ICON/health_hazard_02.png', ['class' => 'attachment-img', 'height' => '35px']); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><?= number_format($value['qty'][0]['kg']); ?> Kg</td>
                                <td class="text-center"><?= number_format($value['qty'][1]['kg']); ?> Kg</td>
                            </tr>
                            <tr>
                                <td class="text-center"><?= number_format($value['qty'][0]['l']); ?> L</td>
                                <td class="text-center"><?= number_format($value['qty'][1]['l']); ?> L</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="background-color: cyan; font-weight: bold;" class="text-center">
                                    Temp : <?= $value['temperature']; ?>&deg;C
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<div class="text-center" style="position: absolute; top: 30px; width: 100%; font-weight: bold; font-size: 40px;">
    <span style="padding: 10px; background-color: #61258e; color: white; border-radius: 10px; letter-spacing: 1.5px;">INFLAM MONITORING</span>
</div>