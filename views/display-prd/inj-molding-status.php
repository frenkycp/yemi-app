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
    'page_title' => 'Molding Maintenance Monitoring <span class="japanesse light-green"></span>',
    'tab_title' => 'Molding Maintenance Monitoring',
    'breadcrumbs_title' => 'Molding Maintenance Monitoring'
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
    }
    .panel {
        margin-bottom: 5px;
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
<?php foreach ($data as $category => $data_val): 
    if ($category == 'running') {
        $title = 'MOLDING TERPASANG';
        $title_class = 'box-primary';
        $bg_class = 'bg-light-blue-active';
    } elseif ($category == 'ready') {
        $title = 'MOLDING READY';
        $title_class = 'box-success';
        $bg_class = 'bg-green-active';
    } else {
        $title = 'MOLDING PERIODIK';
        $title_class = 'box-warning';
        $bg_class = 'bg-yellow-active';
    }
    ?>
    <div class="box <?= $title_class; ?> box-solid" style="display: none;">
        <div class="box-header text-center">
            <h3 class="box-title"><?= $title; ?></h3>
        </div>
    </div>
    <div class="<?= $bg_class; ?> text-center" style="width: 100%; font-size: 30px; padding: 5px;">
        <?= $title; ?>
    </div>
    <div class="row">
        <?php foreach ($data_val as $value): 
            if ($value->MOLDING_STATUS == 0) {
                $loc = 'STORAGE';
            } elseif ($value->MOLDING_STATUS == 1) {
                $loc = $loc_data_arr[$value->MACHINE_ID];
            } else {
                $loc = 'MAINTENANCE';
            }

            $progress = 0;
            if ($value->TARGET_COUNT > 0) {
                $progress = round(($value->TOTAL_COUNT / $value->TARGET_COUNT) * 100, 2);
            }

            
            if ($progress < 70) {
                $progress_bar_class = ' progress-bar-green';
            } elseif ($progress < 100) {
                $progress_bar_class = ' progress-bar-yellow';
            } else {
                $progress_bar_class = ' progress-bar-red';
            }
            ?>
            <div class="col-sm-2">
                <div class=" panel panel-default">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title"><?= $value->MOLDING_NAME; ?></h3>
                    </div>
                    <div class="panel-body no-padding">
                        <div class="progress" style="background-color: #cacaca;">
                            <div class="progress-bar active progress-bar-striped<?= $progress_bar_class; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress > 100 ? 100 : $progress; ?>%; font-size: 11px;"></div>
                        </div>
                        <table class="table summary-tbl" style="">
                            <tbody>
                                <tr>
                                    <td class="text-center" width="80px">SHOTS</td>
                                    <td class="text-center" width="10px">:</td>
                                    <td class="text-center"><?= number_format($value->TOTAL_COUNT); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center" width="80px">LOC</td>
                                    <td class="text-center" width="10px">:</td>
                                    <td class="text-center"><?= $loc; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <br/>
<?php endforeach ?>