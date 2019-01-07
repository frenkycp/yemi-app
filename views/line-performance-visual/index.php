<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

$this->title = [
    'page_title' => '<div class="text-center" style="font-weight: bold">VISUAL LINE PERFORMANCE <span class="japanesse text-green"></span></div>',
    'tab_title' => 'VISUAL LINE PERFORMANCE',
    'breadcrumbs_title' => 'VISUAL LINE PERFORMANCE'
];

$this->registerCss("
	.japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	.content-wrapper {background-color: #33383D;}
	.content-header {color: white;}
	.form-control {background-color: #33383D; color: rgb(255, 235, 59); border-color: #33383D;}
	.box-body {background-color: #33383D; color: rgb(255, 235, 59); font-weight: bold;}
	.box-title {font-weight: bold;}
	.box-header .box-title{font-size: 20px;}
	.container {width: auto;}
	.content-header>h1 {font-size: 3em}
");

$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 10000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
JS;
/*$script = <<< JS
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout("refreshPage();", 10000); // milliseconds
    }
    function refreshPage() {
       $.ajax({
	       url: '<?php echo Yii::$app->request->baseUrl. '/line-performance-visual/update-data'; ?>',
	       type: 'post',
	       data: {
	                 gmc: $("#gmc").val() ,
	                 _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
	             },
	       success: function (data) {
	          console.log(data.search);
	       }
	  });
    }
JS;*/

$this->registerJs($script, View::POS_HEAD );

$avg_min = $avg_eff - 3;
$avg_max = $avg_eff + 3;

if ($gmc == '-') {
	$text = '-';
	$panel_class = 'success';
} else {
	if ($current_eff >= $avg_max) {
		$text = '"BAGUS"';
		$panel_class = 'success';
	} else {
		if ($current_eff >= $avg_min) {
			$text = '"MASUK"';
			$panel_class = 'warning';
		} else {
			$text = '"AYO KAIZEN...!"';
			$panel_class = 'danger';
		}
	}
}


?>
<hr>
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
		            'onchange'=>'this.form.submit()',
		            'style' => 'height: 80px; padding: 3px 12px; font-size:4em;'
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
				<span id="gmc" style="font-size: 4em;"><?= $gmc; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Model</h3>
			</div>
			<div class="box-body">
				<span style="font-size: 4em;"><?= $currently_model; ?></span>
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
				<span style="font-size: 4em;"><?= $mp; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Output Production Time</h3>
			</div>
			<div class="box-body">
				<span style="font-size: 4em;"><?= $last_production_time; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Total Production Time</h3>
			</div>
			<div class="box-body">
				<span style="font-size: 4em;"><?= $total_production_time; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-default box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Efficiency Target</h3>
			</div>
			<div class="box-body">
				<span style="font-size: 4em;"><?= $avg_eff . '%'; ?></span>
			</div>
		</div>
	</div>
</div>
<div class="progress" style="height: 50px; background-color: #363636;">
	<div class="progress-bar progress-bar-striped progress-bar-<?= $panel_class; ?> active" role="progressbar" aria-valuenow="<?= $current_eff; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $current_eff > 100 ? 100 : $current_eff; ?>%; padding: 15px; font-size: 35px;"><?= $current_eff; ?>%</div>
</div>
<hr>
<div class="text-center">
	<span style="font-size: 5em; font-weight: bold; color: white;"><?= $text; ?></span>
</div>
<hr>