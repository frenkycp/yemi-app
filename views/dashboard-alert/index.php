<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\ClinicDataSearch $searchModel
*/

$this->title = [
    //'page_title' => '<u>Dashboard (Alert) <span class="japanesse text-green"></span></u>',
    'page_title' => '',
    'tab_title' => 'Dashboard (Alert)',
    'breadcrumbs_title' => 'Dashboard (Alert)'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
	.content-wrapper {background-color: #000;}
	.content-header {color: white;}
	.form-control, .control-label {background-color: #000; color: rgb(255, 235, 59); border-color: white;}
	.box-title {font-weight: bold;}
	.box-header .box-title, .control-label{font-size: 1.5em;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em; text-align: center;}
	body {background-color: #000;}
	//.small-box {margin: 0px 20px; border:0px solid white;}
");

date_default_timezone_set('Asia/Jakarta');

$this->registerJs("
	function update_machine_status(){
		$.ajax({
	        type: 'POST',
	        url: '" . Url::to(['machine-status']) . "',
	        success: function(data){
	        	if(data.content_str == ''){
	        		$('#machine-container').hide();
	        	} else {
	        		$('#machine-container').show();
	        	}
		    	$('#machine_alert_container').html(data.content_str);
		    },
		    complete: function(){
		    	setTimeout(function(){update_machine_status();}, 1000);
		    }
	    });
	}
	function update_line_status(){
		$.ajax({
	        type: 'POST',
	        url: '" . Url::to(['line-status']) . "',
	        success: function(data){
	        	if(data.content_str == ''){
	        		$('#man-container').hide();
	        	} else {
	        		$('#man-container').show();
	        	}
		    	$('#line_stop_container').html(data.content_str);
		    },
		    complete: function(){
		    	setTimeout(function(){update_line_status();}, 1000);
		    }
	    });
	}
	$(document).ready(function() {
    	update_machine_status();
    	update_line_status();
	});
");
?>
<div class="row" id="man-container" style="display: none;">
	<div class="col-md-12">
		<h3 class="" style="color: white;">MAN</h3>
		<hr>
		<div id="line_stop_container"></div>
	</div>
</div>
<div class="row" id="machine-container" style="display: none;">
	<div class="col-md-12">
		<h3 class="" style="color: white;">MACHINE</h3>
		<hr>
		<div id="machine_alert_container"></div>
	</div>
</div>

<div class="row" style="display: none;">
	<div class="col-md-12">
		<h3 class="" style="color: white;">MATERIAL</h3>
		<hr>
	</div>
</div>
<div class="row" style="display: none;">
	<div class="col-md-12">
		<h3 class="" style="color: white;">METHOD</h3>
		<hr>
	</div>
</div>
<!--<div class="row">
	<div class="col-md-3">
		<div class="box box-solid box-default" id="box_machine">
			<div class="box-header">
              	<h3 class="box-title">Machine Alert</h3>
            </div>
            <div class="box-body">
            	<div id="machine_alert_container"></div>
            </div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-solid box-default" id="box_line_stop">
			<div class="box-header">
              	<h3 class="box-title">Line Stop</h3>
            </div>
            <div class="box-body">
            	<div id="line_stop_container"></div>
            </div>
		</div>
	</div>
</div>-->