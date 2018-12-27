<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

$this->title = [
    'page_title' => 'Line Visual <span class="japanesse text-green"></span>',
    'tab_title' => 'Line Visual',
    'breadcrumbs_title' => 'Line Visual'
];

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

$avg_min = $avg_eff - 5;
$avg_max = $avg_eff + 5;

if ($current_eff >= $avg_max) {
	$text = 'GOOD JOB...';
	$panel_class = 'success';
} else {
	if ($current_eff >= $avg_min) {
		$text = 'AVERAGE...';
		$panel_class = 'warning';
	} else {
		$text = 'IMPROVE EFFICIENCY...!';
		$panel_class = 'danger';
	}
}
?>

<div class="row">
	<div class="col-md-3">
		<div class="box box-success box-solid text-center">
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
		            'style' => 'height: 49px; padding: 3px 12px; font-size:35px;'
		        ]); ?>

		        <?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-success box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">GMC</h3>
			</div>
			<div class="box-body">
				<span id="gmc" style="font-size: 35px;"><?= $gmc; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-success box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Model</h3>
			</div>
			<div class="box-body">
				<span style="font-size: 35px;"><?= $currently_model; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="box box-success box-solid text-center">
			<div class="box-header with-border">
				<h3 class="box-title">Efficiency Target</h3>
			</div>
			<div class="box-body">
				<span style="font-size: 35px;"><?= $avg_eff . '%'; ?></span>
			</div>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-primary text-center">
			<div class="panel-heading">
				<h3 class="panel-title">Total Production Time</h3>
			</div>
			<div class="panel-body">
				<span style="font-size: 35px;"><?= $total_production_time; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-primary text-center">
			<div class="panel-heading">
				<h3 class="panel-title">Last Output Production Time</h3>
			</div>
			<div class="panel-body">
				<span style="font-size: 35px;"><?= $last_production_time; ?></span>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-primary text-center">
			<div class="panel-heading">
				<h3 class="panel-title">Manpower</h3>
			</div>
			<div class="panel-body">
				<span style="font-size: 35px;"><?= $mp; ?></span>
			</div>
		</div>
	</div>
</div>
<div class="progress" style="height: 50px; background-color: #919292;">
	<div class="progress-bar progress-bar-striped progress-bar-<?= $panel_class; ?> active" role="progressbar" aria-valuenow="<?= $current_eff; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $current_eff > 100 ? 100 : $current_eff; ?>%; padding: 15px; font-size: 35px; min-width: 3em;"><?= $current_eff; ?>%</div>
</div>
<hr>
<div class="text-center">
	<span style="font-size: 35px;" class="label label-<?= $panel_class; ?>"><?= $text; ?></span>
</div>