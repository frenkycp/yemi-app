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

?>

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
					'style' => 'text-align: center;'
				])->label('RFID NUMBER') ?>

				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
