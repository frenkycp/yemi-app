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
    .legend {padding-right: 20px;}
    #legend-body {padding: 9px;}

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
            height: 800,
            navLinks: true, 
            editable: true,
            eventLimit: true, 
            editable: false,
            events: '" . Yii::$app->urlManager->createUrl('display/get-daily-receiving') . "' + '?category=' + $('#filter_category').val(),  // request to load current events
            
        });

        $('#filter_category_').change(function(){
            var category_val = $('#filter_category').val();
            //alert(category_val);
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar( 'addEventSource', '" . Yii::$app->urlManager->createUrl('display/get-daily-receiving') . "' + '?category=' + $('#filter_category').val() );
            //$('#calendar').fullCalendar('refetchEvents');
        });
    });

    
";

$this->registerJs($script, View::POS_READY);

$script2 = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script2, View::POS_HEAD );
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['display/receiving-calendar']),
]); ?>

<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'category')->dropDownList([
            'all' => 'All',
            'Container' => 'Container',
            'Truck' => 'Truck',
            'wb' => 'WB',
        ], [
            'class' => 'form-control',
            'id' => 'filter_category',
            'onchange' => 'this.form.submit()',
        ])->label(false); ?>
    </div>
    <div class="col-md-10">
        <div class="panel panel-info">
            <div class="panel-body" id="legend-body">
                <span class="legend">
                    <a class="text-green" href="#"><i class="fa fa-square"></i></a> Plan Date
                </span>
                <span class="legend">
                    <a class="text-light-blue" href="#"><i class="fa fa-square"></i></a> ETA Port Date
                </span>
                <span class="legend">
                    <a class="text-purple" href="#"><i class="fa fa-square"></i></a> ETD Port Date
                </span>
                <span class="legend">
                    <a class="text-aqua" href="#"><i class="fa fa-square"></i></a> Cut Off Date
                </span>
                
                
                
                
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body no-padding">
                <div id="calendar"></div>
            </div>
        </div>

    </div>
</div>

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'header' => '<h3>Detail Information</h3>',
    //'size' => 'modal-lg',
]);
yii\bootstrap\Modal::end();
?>