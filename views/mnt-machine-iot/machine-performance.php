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
    'page_title' => 'IoT Production Machine Performance <span class="japanesse light-green">(生産設備稼働状況)</span>',
    'tab_title' => 'IoT Production Machine Performance',
    'breadcrumbs_title' => 'IoT Production Machine Performance'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
	.japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	.content-wrapper {background-color: #000;}
	.content-header {color: white;}
	.form-control, .control-label {background-color: #000; color: rgb(255, 235, 59); border-color: white;}
	.box-title {font-weight: bold;}
	.box-header .box-title, .control-label{font-size: 1.5em;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em; text-align: center;}
	body {background-color: #000;}
	.panel-body {background-color: black;}
	.btn {margin-bottom: 10px;}
");

date_default_timezone_set('Asia/Jakarta');

$this->registerJs("
	window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 300000); // milliseconds
    }

	function update_data(){
		$.ajax({
	        type: 'POST',
	        url: '" . Url::to(['current-status']) . "',
	        success: function(data){
		    	//alert(data[0].mesin_id);
		    	var content = '';
		    	//alert(data['last_update']);
		    	$('#last-update').html(data['last_update']);
		        $.each(data['data'] , function(index, val) {
		        	var background_color = 'white';
		        	var color = 'white';
		        	if(val.status_warna == 'KUNING'){
		        		//background_color = 'yellow';
		        		color = 'black';
		        		background_color = 'yellow';
		        	} else if (val.status_warna == 'HIJAU') {
		        		background_color = 'green';
		        	} else if (val.status_warna == 'BIRU') {
		        		background_color = 'blue';
		        	} else if (val.status_warna == 'MERAH') {
		        		background_color = 'red';
		        	}

		        	if (background_color != 'white') {
		        		$('#'+val.mesin_id).css('background-color', background_color);
		        		$('#'+val.mesin_id).css('color', color);
		        	}
		        	//var label = val.mesin_id+' - '+val.mesin_description;
		        	//var tmp = '<div class=\"row\"><div class=\"col-md-12\"><button type=\"button\" class=\"\"></button></div></div>';
  					//console.log(index, val.mesin_id);
				});
		    },
		    complete: function(){
		    	setTimeout(function(){update_data();}, 1000);
		    }
	    });
	}
	$(document).ready(function() {
    	update_data();
	});
");
?>
<span style="color: white">Last Update : <span id="last-update"><?= date('Y-m-d H:i:s'); ?></span></span>
<div style="width: 100%; display: table;">
	<div style="display: table-cell; padding: 15px;">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">INJECTION</h3>
			</div>
			<div class="panel-body">
				<?php foreach ($group_arr[0] as $key => $value): ?>
					<button type="button" class="btn btn-default btn-block" style="font-size: 20px;" id="<?= $key; ?>">
						<?= $key . ' | ' . $value; ?>
					</button>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div style="display: table-cell; padding: 15px;">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">REAKTOR</h3>
			</div>
			<div class="panel-body">
				<?php foreach ($group_arr[1] as $key => $value): ?>
					<button type="button" class="btn btn-default btn-block" style="font-size: 20px;" id="<?= $key; ?>">
						<?= $key . ' | ' . $value; ?>
					</button>
				<?php endforeach ?>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">QA CHAMBER</h3>
			</div>
			<div class="panel-body">
				<?php foreach ($group_arr[5] as $key => $value): ?>
					<button type="button" class="btn btn-default btn-block" style="font-size: 20px;" id="<?= $key; ?>">
						<?= $key . ' | ' . $value; ?>
					</button>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div style="display: table-cell; padding: 15px;">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">WW END</h3>
			</div>
			<div class="panel-body">
				<?php foreach ($group_arr[2] as $key => $value): ?>
					<button type="button" class="btn btn-default btn-block" style="font-size: 20px;" id="<?= $key; ?>">
						<?= $key . ' | ' . $value; ?>
					</button>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div style="display: table-cell; padding: 15px;">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">WW MIDDLE</h3>
			</div>
			<div class="panel-body">
				<?php foreach ($group_arr[3] as $key => $value): ?>
					<button type="button" class="btn btn-default btn-block" style="font-size: 20px;" id="<?= $key; ?>">
						<?= $key . ' | ' . $value; ?>
					</button>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div style="display: table-cell; padding: 15px;">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">WW FRONT</h3>
			</div>
			<div class="panel-body">
				<?php foreach ($group_arr[4] as $key => $value): ?>
					<button type="button" class="btn btn-default btn-block" style="font-size: 20px;" id="<?= $key; ?>">
						<?= $key . ' | ' . $value; ?>
					</button>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>
<div>
	<div class="row">
		
		<!-- <?php
		//foreach ($data as $key => $value) {
			?>
			<div class="col-md-6" style="padding: 3px;">
				<button type="button" class="btn btn-default btn-block" style="font-size: 20px;" id="<?= ''; //$value->mesin_id; ?>">
					<?= ''; //$value->mesin_description . ' - ' . $value->mesin_id; ?>
				</button>
			</div>
		<?php //}
		?> -->
		
	</div>
</div>