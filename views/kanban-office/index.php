<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SapPoRcvSearch $searchModel
*/

$this->title = [
    'page_title' => 'Dashboard',
    'tab_title' => 'Kanban Office',
    'breadcrumbs_title' => 'Kanban Office'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

//$this->registerCssFile('@web/css/fullcalendar.css');
//$this->registerJsFile('@web/js/moment.js');
//$this->registerJsFile('@web/js/fullcalendar.js');

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
            events: '" . Yii::$app->urlManager->createUrl('kanban-office/get-daily-kanban') . "' + '?nik=" . $nik . "',  // request to load current events
            
        });
    });

    
";

$this->registerJs($script, View::POS_READY);

?>

<div class="row">
	<div class="col-md-6">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h3><?= number_format($total_request); ?></h3>
				<p>Unconfirm</p>
			</div>
			<div class="icon">
				<i class="fa fa-clipboard"></i>
			</div>
			<?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['data', 'job_stage' => 1], ['class' => 'small-box-footer']); ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="small-box bg-yellow">
			<div class="inner">
				<h3><?= number_format($total_progress); ?></h3>
				<p>On Progress</p>
			</div>
			<div class="icon">
				<i class="fa fa-hourglass-2"></i>
			</div>
			<?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['data', 'job_stage' => 2], ['class' => 'small-box-footer']); ?>
		</div>
	</div>
	<div class="col-md-4" style="display: none;">
		<div class="small-box bg-green">
			<div class="inner">
				<h3>50<sup style="font-size: 0.55em;">%</sup></h3>
				<p>Completion</p>
			</div>
			<div class="icon">
				<i class="fa fa-bar-chart"></i>
			</div>
			<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary box-solid">
        	<div class="box-header">
        		<h3 class="box-title">My Kanban Progress</h3>
        	</div>
            <div class="box-body no-padding">
                <div id="calendar"></div>
            </div>
        </div>

    </div>
</div>