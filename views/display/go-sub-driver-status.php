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
    'page_title' => 'GO Sub Assy Status <small style="color: white; opacity: 0.8;" id="last-update"></small><span class="japanesse light-green"></span>',
    'tab_title' => 'GO Sub Assy Status',
    'breadcrumbs_title' => 'GO Sub Assy Status'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];
$color = 'ForestGreen';

$this->registerCss("
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    //.form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold; background-color: " . \Yii::$app->params['purple_color'] . "; padding: 10px; border-radius: 5px;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    h3, h5 {opacity: 0.9;}

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
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

$this->registerJs("
    function flash_order(){
        $('.label').toggleClass('label-danger');
        setTimeout(function(){flash_order();}, 600);
    }
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['go-sub-driver-status-data']) . "',
            success: function(data){
                $('#container').html(data.content);
                $('#last-update').html(data.last_update);
                $('#driver-chart').html(data.chart);
            },
            complete: function(){
                setTimeout(function(){update_data();}, 3000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
        flash_order();
    });
");

/*echo '<pre>';
print_r($tmp_data);
echo '</pre>';*/
//echo Yii::$app->request->baseUrl;
?>

<div id="container"></div>
<div class="row">
    <div class="col-md-6">
        <ul style="color: white;">
            <li>
                <u><?= Html::a('DRIVER UTILITY (TODAY)', ['display/go-sub-driver-utility'], ['style' => 'color: white;', 'target' => '_blank']); ?></u>
            </li>
            <li>
                <u><?= Html::a('DRIVER UTILITY (MONTHLY)', ['gosub-operation-ratio/index'], ['style' => 'color: white;', 'target' => '_blank']); ?></u>
            </li>
            <li>
                DRIVER TIMELINE (DAILY)
                <ol>
                    <li><u><?= Html::a('NETWORK ASSY', ['display/gosub-timeline', 'terminal' => 'NETWORK ASSY'], ['style' => 'color: white;', 'target' => '_blank']); ?></u></li>
                    <li><u><?= Html::a('FRONT GRILLE ASSY', ['display/gosub-timeline', 'terminal' => 'FRONT GRILLE ASSY'], ['style' => 'color: white;', 'target' => '_blank']); ?></u></li>
                </ol>
            </li>
        </ul>
        
    </div>
    <div class="col-md-6">
    </div>
</div>
