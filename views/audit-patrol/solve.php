<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = [
	    'page_title' => 'Audit Patrol Action <span class="japanesse light-green"></span>',
	    'tab_title' => 'Audit Patrol Action',
	    'breadcrumbs_title' => 'Audit Patrol Action'
	];

?>

<?php $form = ActiveForm::begin([
	'id' => 'AssetTbl',
	//'layout' => 'horizontal',
	'enableClientValidation' => true,
	'errorSummaryCssClass' => 'error-summary alert alert-danger',
]
);
?>

<div class="panel panel-primary">
	<div class="panel-body">
		<?= $form->field($model, 'ACTION')->textInput(['maxlength' => true]) ?>

		<?php
        echo $form->field($model, 'upload_after_1')->widget(\kartik\file\FileInput::className(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  ' Select Photo',
                'initialPreview' => $model->IMAGE_AFTER_1 == null ? [] : [
                    Html::img('@web/uploads/AUDIT_PATROL/' . $model->IMAGE_AFTER_1, ['width' => '100%'])
                ],
            ],
        ])->label('Image After');
        ?>
	</div>
	<div class="panel-footer">
        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> Submit',
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-warning']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>