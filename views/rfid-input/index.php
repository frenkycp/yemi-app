<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

$this->title = [
    'page_title' => '<div class="text-center" style="font-weight: bold">RFID Input Form <span class="japanesse text-green"></span></div>',
    'tab_title' => 'RFID Input Form',
    'breadcrumbs_title' => 'RFID Input Form'
];

$script = <<< JS
    $(document).on('beforeSubmit', 'form', function(event) {
        $(this).find('[type=text]').attr('readonly', true);
    });
JS;
$this->registerJs($script, View::POS_HEAD);

$this->registerCss("
	.control-label { font-size: 2em;}
	.content-header { display: none;}
");

?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary text-center">
			<div class="panel-heading">
				<h3 class="panel-title" style="font-size: 2em;">RFID REGISTERED</h3>
			</div>
			<div class="panel-body">
				<span style="font-weight: bold; font-size: 3em;"><?= $total_registered; ?> PCS</span>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-center">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php $form = ActiveForm::begin([
				    'method' => 'post'
				]); ?>

				<?= $form->field($model, 'rfid', [
					'inputOptions' => [
						'autofocus' => 'autofocus',
					],
				])->textInput([
					'style' => 'text-align: center; font-size: 2em;'
				])->label('RFID INPUT FORM') ?>

				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
	
</div>
