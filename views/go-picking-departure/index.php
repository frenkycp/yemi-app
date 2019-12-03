<?php
use yii\bootstrap\ActiveForm;

$this->title = [
    'page_title' => 'Transporter Departure Control (PICKING)',
    'tab_title' => 'Transporter Departure Control (PICKING)',
    'breadcrumbs_title' => 'Transporter Departure Control (PICKING)'
];

$this->registerCss("
    .japanesse-word { 
        font-family: 'MS PGothic', Osaka, Arial, sans-serif; 
    }
    .content-header {
        text-align: center;
    }
");
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

?>
<div class="col-md-4 col-md-offset-4 text-center">
	<div class="panel panel-default">
		<div class="panel-body">
			<?php $form = ActiveForm::begin([
			    'method' => 'post'
			]); ?>

			<?= $form->field($model, 'slip_id', [
				'inputOptions' => [
					'autofocus' => 'autofocus'
				],
			])->textInput([
				'style' => 'text-align: center;'
			])->label('SLIP NUMBER') ?>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>