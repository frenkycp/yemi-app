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
    'page_title' => 'IoT Production Machine Performance <span class="japanesse text-green"></span>',
    'tab_title' => 'IoT Production Machine Performance',
    'breadcrumbs_title' => 'IoT Production Machine Performance'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
	.japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	.content-wrapper {background-color: #33383D;}
	.content-header {color: white;}
	.form-control, .control-label {background-color: #33383D; color: rgb(255, 235, 59); border-color: white;}
	.box-title {font-weight: bold;}
	.box-header .box-title, .control-label{font-size: 1.5em;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em; text-align: center;}
	body {background-color: #33383D;}
");

date_default_timezone_set('Asia/Jakarta');

$this->registerJs("
	function update_data(){
		$.ajax({
	        type: 'POST',
	        url: '" . Url::to(['current-status']) . "',
	        success: function(data){
		    	//alert(data[0].mesin_id);
		    	var content = '';
		        $.each(data , function(index, val) {
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

<div>
	<div class="row">
		<div class="col-md-12">
				<?php
				foreach ($data as $key => $value) {
					?>
					<button type="button" class="btn btn-default btn-block" style="font-size: 20px;" id="<?= $value->mesin_id; ?>">
						<?= $value->mesin_id . ' - ' . $value->mesin_description; ?>
					</button>
				<?php }
				?>
		</div>
	</div>
</div>