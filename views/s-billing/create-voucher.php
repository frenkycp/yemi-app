<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;

$this->title = Yii::t('models', 'Create Voucher');

?>

<?php $form = ActiveForm::begin([
'id' => 'Menu',
//'layout' => 'horizontal',
'enableClientValidation' => true,
'options' => ['enctype' => 'multipart/form-data'],
'errorSummaryCssClass' => 'error-summary alert alert-error'
]
);
?>
<div class="row">
	<div class="col-sm-3">
		<?= $form->field($model, 'voucher_no')->textInput(); ?>
	</div>
	<div class="col-sm-6">
		<?php
		echo $form->field($model, 'attachment_file')->widget(\kartik\file\FileInput::className(), [
            'pluginOptions' => [
                'showCaption' => true,
		        'showRemove' => false,
		        'showUpload' => false,
		        'showPreview' => false,
		        'browseClass' => 'btn btn-primary btn-block',
		        'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
		        'browseLabel' =>  ' Select File'
            ],
            'options' => ['accept' => 'pdf']
        ]);
        ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?= $form->field($model, 'base64_txt')->textArea(); ?>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<?= $form->field($model, 'invoice_no')->widget(Select2::classname(), [
		    'data' => ArrayHelper::map(app\models\SupplierBilling::find()->where(['stage' => 2])->all(), 'no', 'invoice_no'),
		    'options' => ['placeholder' => 'Select invoice ...'],
		    'pluginOptions' => [
		        'allowClear' => true,
		        'multiple' => true
		    ],
		]); ?>
	</div>
</div>

<?= Html::a(
'Cancel',
\yii\helpers\Url::previous(),
['class' => 'btn btn-warning']) ?>

<?= Html::submitButton(
'<span class="glyphicon glyphicon-check"></span> ' .
($model->isNewRecord ? 'Create' : 'Submit'),
[
'id' => 'save-' . $model->formName(),
'class' => 'btn btn-success'
]
);
?>

<?php ActiveForm::end(); ?>