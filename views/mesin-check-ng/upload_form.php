<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Corrective Upload Image');
?>

<div class="panel panel-primary">
	<div class="panel-heading">
    	<h3 class="panel-title">Upload Form</h3>
	</div>
	<div class="panel-body">
		<?php
		$form = ActiveForm::begin([
			'id' => 'MesinCheckNg',
			'layout' => 'horizontal',
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

		echo $form->field($model, 'upload_file')->widget(\kartik\file\FileInput::className(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'allowedFileExtensions' => ['jpg'],
                //'maxFileSize' => 250,
            ],
        ]);
        ?>

        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-2">
                <?= Html::img(["uploads/NG_MNT/" . $urutan . '.jpg'], ["width"=>"150px"]); ?>
            </div>
        </div>

        <?php

		echo $form->errorSummary($model);

        echo Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> Upload',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );

        ActiveForm::end();
		?>
	</div>
</div>
