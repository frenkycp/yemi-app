<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

date_default_timezone_set('Asia/Jakarta');

$this->title = [
    'page_title' => '<div class="text-center" style="font-weight: bold">VISUAL LINE PERFORMANCE <span class="japanesse text-green"></span><br/><em id="last-update-text" style="font-size: 0.5em; font-weight: normal;">Last Update : ' . date('Y-m-d H:i:s') . '</em></div>',
    'tab_title' => 'VISUAL LINE PERFORMANCE',
    'breadcrumbs_title' => 'VISUAL LINE PERFORMANCE'
];

$this->registerCss("
	.japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	.content-wrapper {background-color: #000;}
	.content-header {color: white;}
	.form-control {background-color: #000; color: rgb(255, 235, 59); border-color: #000;}
	.box-body {background-color: #000; color: rgb(255, 235, 59); font-weight: bold;}
	.box-title {font-weight: bold;}
	.box-header .box-title{font-size: 20px;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em}
	body {background-color: #000;}
");

/*$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 1000000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
$this->registerJs($script, View::POS_END);*/

$this->registerJs("
    function update_data(){
        $.ajax({
            type: 'POST',
            url: '" . Url::to(['index-update', 'line' => $line]) . "',
            success: function(data){
                var tmp_data = JSON.parse(data);
                $('#gmc').html(tmp_data.gmc);
                $('#current-model').html(tmp_data.currently_model);
                $('#manpower-qty').html(tmp_data.mp);
                $('#last-production-time').html(tmp_data.last_production_time);
                $('#total-production-time').html(tmp_data.total_production_time);
                $('#total-eff').html(tmp_data.total_eff + '%');
                $('#avg-eff').html(tmp_data.avg_eff + '%');
                $('#progress-bar-id').html(tmp_data.progress_content);
                $('#text-bagus').html(tmp_data.text_bagus_content);
                $('#last-update-text').html('Last Update : ' + tmp_data.last_update);
            },
            complete: function(){
                setTimeout(function(){update_data();}, 3000);
            }
        });
    }
    $(document).ready(function() {
        update_data();
    });
");



$avg_min = $avg_eff - 3;
$avg_max = $avg_eff + 3;

if ($gmc == '-') {
	$text = '-';
	$panel_class = 'success';
	$text_class = 'text-green';
} else {
	if ($current_eff >= $avg_max) {
		$text = '"BAGUS"';
		$panel_class = 'success';
		$text_class = 'text-green';
	} else {
		if ($current_eff >= $avg_min) {
			$text = '"MASUK"';
			$panel_class = 'warning';
			$text_class = 'text-yellow';
		} else {
			$text = '"AYO KAIZEN...!"';
			$panel_class = 'danger';
			$text_class = 'text-danger';
		}
	}
}


?>

<div class="row">
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Line</h3>
			</div>
			<div class="box-body">
				<?php $form = ActiveForm::begin([
				    'method' => 'get',
				    //'layout' => 'horizontal',
				    'action' => Url::to(['line-performance-visual/index']),
				]); ?>

		        <?= Html::dropDownList('line', \Yii::$app->request->get('line'), $line_dropdown, [
		            'class' => 'form-control',
		            'id' => 'line-input',
		            'onchange'=>'this.form.submit()',
		            'style' => 'height: 60px; padding: 3px 12px; font-size:3em;'
		        ]); ?>

		        <?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">GMC</h3>
			</div>
			<div class="box-body">
				<span id="gmc" style="font-size: 3em;"><?= $gmc; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Model</h3>
			</div>
			<div class="box-body">
				<span id="current-model" style="font-size: 3em;"><?= $currently_model; ?></span>
			</div>
		</div>
	</div>
	
</div>
	
<div class="row">
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Manpower</h3>
			</div>
			<div class="box-body">
				<span id="manpower-qty" style="font-size: 3em;"><?= $mp; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Output Production Time</h3>
			</div>
			<div class="box-body">
				<span id="last-production-time" style="font-size: 3em;"><?= $last_production_time; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Total Production Time</h3>
			</div>
			<div class="box-body">
				<span id="total-production-time" style="font-size: 3em;"><?= $total_production_time; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Efficiency Total</h3>
			</div>
			<div class="box-body">
				<span id="total-eff" style="font-size: 3em;"><?= $total_eff . '%'; ?></span>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Efficiency Target</h3>
			</div>
			<div class="box-body">
				<span id="avg-eff" style="font-size: 3em;"><?= $avg_eff . '%'; ?></span>
			</div>
		</div>
	</div>
</div>
<div id="progress-bar-id" class="progress" style="height: 50px; background-color: #363636; outline: 2px solid white;">
	<div class="progress-bar progress-bar-striped progress-bar-<?= $panel_class; ?> active" role="progressbar" aria-valuenow="<?= $current_eff; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $current_eff > 100 ? 100 : $current_eff; ?>%; padding: 15px; font-size: 35px;"><?= $current_eff; ?>%</div>
</div>
<hr>
<div class="text-center" id="text-bagus">
	<span style="font-size: 4em; font-weight: bold; text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;" class="<?= $text_class; ?>"><?= $text; ?></span>
</div>
<hr>