<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

$this->title = 'Full Calendar';
$this->params['breadcrumbs'][] = $this->title;
$color = 'ForestGreen';

date_default_timezone_set('Asia/Jakarta');

$this->registerCss("
    .japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; color: #82b964;}
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
            navLinks: true, 
            editable: true,
            eventLimit: true, 
            editable: false,
            events: '" . Yii::$app->urlManager->createUrl('test/get-daily-receiving') . "',  // request to load current events
            
        });
    });
";

$this->registerJs($script, View::POS_READY);
?>
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <div id="calendar"></div>
            </div>
        </div>

    </div>
</div>
