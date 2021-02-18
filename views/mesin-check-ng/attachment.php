<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Add Attachment');
?>

<div class="panel panel-primary">
	<div class="panel-body">
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
		
		<div class="row">
			<div class="col-md-6">
				<div class="box box-warning box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Attachment</h3>
					</div>
					<div class="box-body">
						<?php
						echo $form->field($model, 'attachment')->widget(\kartik\file\FileInput::className(), [
				            'pluginOptions' => [
				                'showCaption' => false,
						        'showRemove' => false,
						        'showUpload' => false,
						        'browseClass' => 'btn btn-primary btn-block',
						        'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
						        'browseLabel' =>  ' Select File'
				            ],
				        ])->label(false);
				        ?>
				        <!--<div class="form-group">
							<?= ''; //Html::img(['uploads/NG_MNT/' . $urutan . '_1.jpg'], ["width"=>"150px"]); ?>
				        </div>-->
					</div>
				</div>
			</div>
		</div>

        <?php

		echo $form->errorSummary($model);
		?>
	</div>
	<div class="panel-footer text-right">
		<?php
		echo Html::submitButton(
        '<span class="glyphicon glyphicon-cloud-upload"></span> Submit',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
		?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
