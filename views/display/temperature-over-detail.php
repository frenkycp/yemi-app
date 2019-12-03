<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

$this->title = [
    'page_title' => $area,
    'tab_title' => $area,
    'breadcrumbs_title' => $area
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 30px; height: 52px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    //.container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}

    .temp-tbl{
        border:1px solid #ddd;
        border-top: 0;
    }
    .temp-tbl > thead > tr > th{
        font-weight: normal;
        border:1px solid #8b8c8d;
        background-color: " . \Yii::$app->params['purple_color'] . ";
        color: white;
        font-size: 1.5em;
        border-bottom: 7px solid #ddd;
        vertical-align: middle;
    }
    .temp-tbl > tbody > tr > td{
        border:1px solid #ddd;
        font-size: 1.2em;
        background-color: #000;
        //font-weight: 1000;
        //color: rgba(255, 235, 59, 1);
        color: white;
        vertical-align: middle;
    }

");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 600000); // milliseconds
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
<div style="float: right; margin-bottom: 5px;">
    <?= Html::a('Back', Url::previous(), ['class' => 'btn btn-warning']); ?>
</div>

<table class="table table-bordered table-condensed temp-tbl">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th class="text-center">Day</th>
            <th class="text-center">Date</th>
            <th class="text-center">Time</th>
            <th class="text-center">Shift</th>
            <th class="text-center">Max. Temperature (&deg;C)</th>
            <th class="text-center">Actual Temperature (&deg;C)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($data_table) > 0) {
            $no = 1;
            foreach ($data_table as $key => $value) {
                echo '<tr>
                    <td class="text-center">' . $no++ . '</td>
                    <td class="text-center">' . date('D', strtotime($value->system_date_time)) . '</td>
                    <td class="text-center">' . date('d M \'Y', strtotime($value->system_date_time)) . '</td>
                    <td class="text-center">' . date('H:i', strtotime($value->system_date_time)) . '</td>
                    <td class="text-center">' . $value->shift . '</td>
                    <td class="text-center">' . $value->temp_max . '</td>
                    <td class="text-center">' . $value->temparature . '</td>
                </tr>';
            }
        } else {
            echo '<tr>
                <td colspan="6">No detail data ...</td>
            </tr>';
        }
        ?>
    </tbody>
</table>