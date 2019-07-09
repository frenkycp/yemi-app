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
    'page_title' => 'Container Loading by Group <span class="japanesse text-green">(グループ別コンテナー積み込み作業表)</span>',
    'tab_title' => 'Container Loading by Group',
    'breadcrumbs_title' => 'Container Loading by Group'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

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
        font-size: 28px;
        //background-color: #B3E5FC;
        //font-weight: 1000;
        color: #FFF;
        vertical-align: middle;
    }
");

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
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>
<span style="color: white; font-size: 1.7em;"> LAST UPDATE : <?= date('Y-m-d H:i:s'); ?> </span>
<table class="table table-bordered" id="progress-tbl">
    <thead>
        <tr>
            <th style="color: #f1e115;" class="text-center" width="10%">GATE</th>
            <th style="color: #f1e115;" class="text-center" width="10%">CONTAINER ID</th>
            <th style="color: #f1e115;" width="20%">PORT<br/>(港先)</th>
            <th style="color: #f1e115;" class="text-center" width="30%">LOADING TIME<br/>(TARGET MAX. 60 MINUTES)</th>
            <th style="color: #f1e115;" class="text-center" width="10%">GROUP</th>
            <th style="color: #f1e115;" class="text-center" width="10%">START</th>
            <th style="color: #f1e115;" class="text-center" width="10%">END</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($tmp_data as $key => $value) {
            $now = date('Y-m-d H:i:s');
            $today_name = date('D');
            $start_date = new DateTime($value['start']);
            $end_date = new DateTime($now);
            $break_time1 = new DateTime(date('Y-m-d 09:20:00'));
            $break_time2 = new DateTime(date('Y-m-d 11:40:00'));
            $break_time3 = new DateTime(date('Y-m-d 14:20:00'));
            $min1 = $min3 = 10;
            $min2 = 40;
            if ($value['status'] == 2) {
                $end_date = new DateTime($value['tgl']);
            }
            $since_start = $start_date->diff($end_date);

            $minutes = $since_start->days * 24 * 60;
            $minutes += $since_start->h * 60;
            $minutes += $since_start->i;

            if ($today_name == 'Fri') {
                $min2 = 70;
                $break_time2 = new DateTime(date('Y-m-d 12:00:00'));
                $break_time3 = new DateTime(date('Y-m-d 14:50:00'));
            }

            if ($start_date < $break_time1 && $end_date > $break_time1) {
                $minutes -= $min1;
            }

            if ($start_date < $break_time2 && $end_date > $break_time2) {
                $minutes -= $min2;
            }

            if ($start_date < $break_time3 && $end_date > $break_time3) {
                $minutes -= $min3;
            }

            //echo $end_date->format('Y-m-d H:i:s');

            $minutes_pct = round(($minutes / 60) * 100, 1);
            $time_start = $time_end = '';
            $active_class = '';
            if ($value['status'] == 1) {
                $time_start = date('H:i', strtotime($value['start']));
                $active_class = ' progress-bar-striped active';
            }
            if ($value['status'] == 2) {
                $time_start = date('H:i', strtotime($value['start']));
                $time_end = date('H:i', strtotime($value['tgl']));
            }

            $color_css = ' progress-bar-green';
            if ($minutes_pct > 100) {
                $color_css = ' progress-bar-red';
            }

            ?>
            <tr>
                <td class="text-center" style="font-weight: bold;"><?= $value['status'] == 2 ? 'EXPORTED' : $value['gate']; ?></td>
                <td class="text-center"><?= $value['cntr']; ?></td>
                <td style="font-weight: bold;"><?= $value['dst']; ?></td>
                <td>
                    <div class="progress" style="height: 50px; background-color: #33383D; outline: 2px solid white;">
                        <div class="progress-bar<?= $color_css; ?><?= $active_class; ?>" role="progressbar" style="width: <?= $minutes_pct > 100 ? 100 : $minutes_pct; ?>%; font-size: 35px; padding-top: 13px;" aria-valuenow="<?= $minutes_pct; ?>" aria-valuemin="0" aria-valuemax="100"><span style="text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;"><?= $minutes == 0 ? '' : $minutes; ?></span></div>
                    </div>
                    <span class="text-yellow" style="font-size: 18px;<?= $value['remark'] == '' ? ' display: none;' : ''; ?>"><em><?= '* ' . $value['remark']; ?></em></span>
                </td>
                <td class="text-center" style="font-weight: bold;"><?= $value['line']; ?></td>
                <td class="text-center"><?= $time_start; ?></td>
                <td class="text-center"><?= $time_end; ?></td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>