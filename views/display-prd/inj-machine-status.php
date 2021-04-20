<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use app\models\TraceItemScrap;

$this->title = [
    'page_title' => 'Injection Machine Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Injection Machine Monitoring',
    'breadcrumbs_title' => 'Injection Machine Monitoring'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$css_string = "
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white; font-size: 10px; text-align: center;}
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
    .no-padding {
        margin: 0.5px;
    }
    .summary-tbl{
        //border:1px solid #29B6F6;
        border-top: 0;
        margin-bottom: 0px;
    }
    .summary-tbl > tbody > tr > td{
        border:1px solid white;
        font-size: 14px;
        background: #33383d;
        color: #FFF;
        vertical-align: middle;
        padding: 10px 10px;
        letter-spacing: 1.1px;
        //height: 100px;
    }
    .summary-tbl > thead > tr > th{
        border:1px solid #8b8c8d;
        background-color: #518469;
        color: white;
        font-size: 12px;
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
        background: #000;
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
    .box-body {
        background-color: black;
    }
    .box {
        margin-bottom: 0px;
    }
    .panel-body {
        background-color: #33383d;
        color: white;
    }
    .panel-title {
        font-weight: bold;
        font-size: 30px;
    }
    .panel {
        //margin-bottom: 5px;
        margin-top: 5px;
    }
    .progress {
        height: 30px;
        margin: 3px;
    }
    .content {
        padding: 5px;
    }
    .label-tbl {padding-left: 20px !important;}
    .text-red {color: #ff7564 !important;}
    .desc-number {color: white; text-shadow: -1px -1px 0 #0F0}
    //tbody > tr > td { background: #33383d;}
    //.summary-tbl > tbody > tr:nth-child(odd) > td {background: #454B52;}
    .accumulation > td {
        background: #454B52 !important;
    }
    .bg-yellow-mod {background-color: yellow !important;}
    .icon-status {font-size : 3em;}
    .target, .actual {font-size: 4em !important;}
    .bg-black {background-color: black; color: yellow !important;}
    .total-nolog {font-size: 20em;}
    td {vertical-align: middle !important;}
    hr {
        margin-bottom: 0px;
    }
    .disabled-link {color: DarkGrey; cursor: not-allowed;}
    .expired-um {
        font-size: 60px;
        font-weight: bold;
        border: 1px solid black;
    }
    li, .panel-title, .box-title {letter-spacing: 1.2px;}";
$this->registerCss($css_string);

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 60000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

/*echo '<pre>';
print_r($data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<br/>
<div class="row">
    <?php foreach ($data_machine as $machine_val):
        $total_shot = $shot_pct = 0;
        foreach ($data_molding as $molding_val) {
            if ($machine_val->MOLDING_ID == $molding_val->MOLDING_ID) {
                $total_shot = $molding_val->TOTAL_COUNT;
                $shot_pct = $molding_val->SHOT_PCT;
            }
        }

        $shot_txt = '<i class="text-red">NO MOLDING SET</i>';
        if ($machine_val->MOLDING_ID != null) {
            $shot_txt = 'Shot ' . $machine_val->MOLDING_NAME . ' : <b>' . $total_shot . '</b>';
        }

        $item_txt = '<i class="text-red">NO PART SET</i>';
        if ($machine_val->ITEM != null) {
            $item_txt = $machine_val->ITEM . ' - ' . $machine_val->ITEM_DESC;
        }

        if ($shot_pct < 70) {
            $progress_bar_class = ' progress-bar-green';
        } elseif ($shot_pct < 100) {
            $progress_bar_class = ' progress-bar-yellow';
        } else {
            $progress_bar_class = ' progress-bar-red';
        }
        ?>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">MACHINE <?= $machine_val->MACHINE_ALIAS; ?></h3>
                </div>
                <div class="panel-body no-padding">
                    <div class="progress" style="background-color: #cacaca;">
                        <div class="progress-bar active progress-bar-striped<?= $progress_bar_class; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $shot_pct > 100 ? 100 : $shot_pct; ?>%;"></div>
                    </div>
                    <div class="text-center" style="letter-spacing: 2px; font-size: 20px;"><?= $shot_txt; ?></div>
                    <hr style="margin: 5px; height: 2px;">
                    <div class="text-center" style="margin-bottom: 5px; letter-spacing: 2px; font-size: 20px;"><?= $item_txt; ?></div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
