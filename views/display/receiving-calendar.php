<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => null,
    'tab_title' => 'Receiving Calendar',
    'breadcrumbs_title' => 'Receiving Calendar'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif;}
    .form-control, .control-label {background-color: #000; color: white; border-color: white;}
    .form-control {font-size: 20px; height: 40px;}
    .content-header {color: white;}
    //.box-body {background-color: #000;}
    .box-title {font-weight: bold;}
    .box-header .box-title, .control-label{font-size: 2em;}
    .container {width: auto;}
    .content-header>h1 {font-size: 3.5em; font-family: sans-serif; font-weight: bold;}
    body {background-color: #ecf0f5;}
    .form-group {margin-bottom: 0px;}
    body, .content-wrapper {background-color: #000;}
    .small-box .icon {top: 1px;}
    .inner p {font-size: 18px;}
    .form-horizontal .control-label {padding-top: 0px;}
    .active a {background-color: #3c8dbc !important; font-size: 18px; color: white !important;}
");

$this->registerCssFile('@web/css/fullcalendar.css');
$this->registerJsFile('@web/js/moment.js');
$this->registerJsFile('@web/js/fullcalendar.js');

$script = "
    $(document).ready(function() {

        // page is now ready, initialize the calendar..
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            height: 870,
            navLinks: true, 
            editable: true,
            eventLimit: true, 
            editable: false,
            events: '" . Yii::$app->urlManager->createUrl('display/get-daily-receiving') . "',  // request to load current events
            
        });
    });
";

$this->registerJs($script, View::POS_READY);
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <div id="calendar"></div>
            </div>
        </div>

    </div>
</div>
