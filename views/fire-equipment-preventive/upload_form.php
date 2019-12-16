<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Upload Image');
?>

		<?php
		$form = ActiveForm::begin([
			'id' => 'MesinCheckNg',
			//'layout' => 'horizontal',
			'enableClientValidation' => true,
			'errorSummaryCssClass' => 'error-summary alert alert-danger',
			'options' => ['enctype' => 'multipart/form-data'],
			'fieldConfig' => [
				'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
				'horizontalCssClasses' => [
					'label' => 'col-sm-2',
					#'offset' => 'col-sm-offset-4',
					'wrapper' => 'col-sm-8',
					'error' => '',
					'hint' => '',
				],
			],
		]);
		?>
		
				<div class="box box-warning box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Image (<?= $mesin_id; ?>)</h3>
					</div>
					<div class="box-body">
						<?php
						echo $form->field($model, 'upload_file')->widget(\kartik\file\FileInput::className(), [
				            'options' => ['accept' => 'image/*'],
				            'pluginOptions' => [
				                'allowedFileExtensions' => ['jpg'],
				                'showCaption' => false,
						        'showRemove' => false,
						        'showUpload' => false,
						        'browseClass' => 'btn btn-primary btn-block',
						        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
						        'browseLabel' =>  ' Select Photo'
				            ],
				        ])->label(false);
				        ?>
				        <?php
						echo Html::submitButton(
				        '<span class="glyphicon glyphicon-cloud-upload"></span> Upload',
				        [
				        'id' => 'save-' . $model->formName(),
				        'class' => 'btn btn-success btn-block pull-right'
				        ]
				        );
						?>
					</div>
				</div>

        <?php

		echo $form->errorSummary($model);
		?>
	<?php ActiveForm::end(); ?>
